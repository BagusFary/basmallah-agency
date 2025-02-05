<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use App\Models\UserSubmission;
use App\Models\UserSubmissions;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use App\Exports\UserSubmissionsExport;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\UserSubmissionExporter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserSubmissionsResource\Pages;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;
use App\Filament\Resources\UserSubmissionsResource\RelationManagers;

class UserSubmissionsResource extends Resource
{
    protected static ?string $model = UserSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('housing_partner_id')
                    ->relationship(name: 'housingPartner', titleAttribute: 'name')
                    ->native(false)
                    ->label('Perumahan'),
                TextInput::make('email')
                ->label('Email'),
                TextInput::make('phone')
                ->label('No Whatsapp'),
                TextInput::make('name')
                ->label('Nama'),
                TextInput::make('id_card')
                ->label('NIK'),
                TextInput::make('address')
                ->label('Alamat'),
                Select::make('employment_status')
                    ->options([
                        'self_employees' => 'Wirausaha',
                        'civil_servants' => 'PNS',
                        'employees' => 'Karyawan'
                    ])
                    ->native(false)
                    ->label('Status Pekerjaan'),
                TextInput::make('avg_monthly_turnover')
                    ->numeric()
                    ->label('Omset Rata-Rata Bulanan'),
                Radio::make('has_instalment')
                    ->options([
                        '1' => 'Yes',
                        '0' => 'No'
                    ])
                    ->label('Punya Cicilan?'),
                TextInput::make('instalment_amount')
                ->label('Jumlah Cicilan'),
                TextInput::make('referral_code')
                ->label('Kode Referal'),
                Repeater::make('Income')
                ->label('Penghasilan')
                    ->schema([
                        Select::make('type')
                            ->options([
                                'self' => 'Sendiri',
                                'Join Income' => [
                                    'join-husband' => 'Gaji Suami',
                                    'join-wife' => 'Gaji Istri'
                                ]

                            ]),
                        TextInput::make('salary')
                            ->numeric()
                    ])
                    ->relationship('incomes')
                    ->defaultItems(1)
            ]);
    }

    protected static function getIncome(UserSubmission $model)
    {
        $dynamicSchemaIncome = [];
        foreach ($model->incomes as $income) {
            $dynamicSchemaIncome[] = TextInput::make("income_{$income->id}")
                ->label(function () use ($income) {
                    $getType = $income->type;
                    if ($getType === 'self')
                        return 'Jumlah Penghasilan Pribadi';
                    if ($getType === 'join-husband')
                        return 'Jumlah Penghasilan Suami';
                    if ($getType === 'join-wife')
                        return 'Jumlah Penghasilan Istri';
                })
                ->default(fn() => $income->salary ?? 0)
                ->readOnly()
                ->prefix('Rp.')
                ->mask(RawJs::make('$money($input)'));
        }

        return $dynamicSchemaIncome;
    }
    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('housingPartner.name')
                    ->label('Perumahan')
                    ->searchable(),
                TextColumn::make('id_card')
                    ->label('NIK')
                    ->searchable(['email','address', 'phone', 'name', 'id_card', ]),
                TextColumn::make('name')
                    ->label('Nama'),
                TextColumn::make('email')
                    ->label('Email'),
                TextColumn::make('address')
                    ->label('Alamat')

            ])
            ->filters([
                
            ])
            ->headerActions([
                Action::make('exportGlobal')
                        ->label('Export Excel')
                        ->icon('heroicon-m-folder-arrow-down')
                        ->form([
                            Section::make()
                                ->schema([
                                    Select::make('housing_partner_id')
                                        ->label('Housing Partner')
                                        ->relationship('housingPartner', 'name')
                                        ->placeholder('Pilih Housing Partner')
                                        ->native(false),
                                    DateRangePicker::make('created_at')
                                        ->label('Rentang Tanggal')
                                        ->placeholder('Pilih Rentang Tanggal'),
                                    Select::make('employment_status')
                                        ->label('Status Pekerjaan')
                                        ->placeholder('Pilih Status Pekerjaan')
                                        ->options([
                                            'self_employees' => 'Wirausaha',
                                            'civil_servants' => 'PNS',
                                            'employee' => 'Pegawai Swasta',
                                        ])
                                        ->native(false)
                                        ->live(),
                                    TextInput::make('avg_monthly_turnover')
                                        ->label('Omset Rata - Rata Perbulan')
                                        ->placeholder('Masukkan Omset Perbulan')
                                        ->inputMode('numeric')
                                        ->minValue(0)
                                        ->numeric()
                                        ->prefix('Rp.')
                                        ->mask(RawJs::make('$money($input)'))
                                        ->stripCharacters(',')
                                        ->visible(fn ($get) => $get('employment_status') === 'self_employees'),
                                    Select::make('has_instalment')
                                        ->label('Punya Cicilan')
                                        ->placeholder('Apakah user memiliki cicilan ?')
                                        ->options([
                                            "1" => 'Ya', 
                                            "0" => 'Tidak'
                                        ])
                                        ->native(false)
                                        ->live(),
                                    TextInput::make('instalment_amount')
                                            ->label('Jumlah Cicilan')
                                            ->placeholder('Masukkan Jumlah Cicilan')
                                            ->inputMode('numeric')
                                            ->minValue(1)
                                            ->numeric()
                                            ->prefix('Rp.')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(',')
                                            ->visible(fn ($get) => $get('has_instalment') === "1" ),
                                    
                                ])
                                ->columns(2)
                        ])
                        ->action(function(array $data){
                            return Excel::download(new UserSubmissionsExport($data), 'RekapitulasiForm-' . now()->format('Ymd_His') . '.xlsx');
                        })
                        
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('detail')
                    ->form([
                        Section::make(fn(UserSubmission $record): string => $record->housingPartner->name)
                            ->schema([
                                TextInput::make('id_card')
                                    ->default(fn(UserSubmission $record): string => $record->id_card)
                                    ->readOnly()
                                    ->label('NIK')
                                    ->extraAttributes([
                                        'class' => '!border-none !ring-0 !focus:ring-0 !focus:border-none',
                                    ]),
                                TextInput::make('name')
                                    ->default(fn(UserSubmission $record): string => $record->name)
                                    ->readOnly()
                                    ->label('Nama'),
                                TextInput::make('email')
                                    ->default(fn(UserSubmission $record): string => $record->email)
                                    ->readOnly()
                                    ->label('Email'),
                                TextInput::make('address')
                                    ->default(fn(UserSubmission $record): string => $record->address)
                                    ->readOnly()
                                    ->label('Alamat'),
                                TextInput::make('employment_status')
                                    ->default(function (UserSubmission $record) {
                                        $getEmployee = $record->employment_status;
                                        if ($getEmployee === 'self_employees')
                                            return 'Wirausaha';
                                        if ($getEmployee === 'civil_servants')
                                            return 'PNS';
                                        if ($getEmployee === 'employees')
                                            return 'Karyawan';
                                    })
                                    ->readOnly()
                                    ->label('Status Pekerjaan'),
                                TextInput::make('avg_monthly_turnover')
                                    ->default(fn(UserSubmission $record): string => $record->avg_monthly_turnover)
                                    ->readOnly()
                                    ->label('Omset Bulanan Rata-Rata')
                                    ->visible(function (UserSubmission $record) {
                                        $getEmployee = $record->employment_status;
                                        return $getEmployee === 'self_employees' ? true : false;
                                    })
                                    ->prefix('Rp.')
                                    ->mask(RawJs::make('$money($input)')),
                                TextInput::make('has_instalment')
                                    ->default(fn(UserSubmission $record): string => $record->has_instalment === 0 ? 'Tidak' : '')
                                    ->readOnly()
                                    ->label('Punya Cicilan?')
                                    ->visible(function (UserSubmission $record) {
                                        $getInstalment = $record->has_instalment;
                                        return $getInstalment === 0 ? true : false;
                                    }),
                                TextInput::make('instalment_amount')
                                    ->default(fn(UserSubmission $record): string => $record->instalment_amount)
                                    ->readOnly()
                                    ->label('Total Cicilan')
                                    ->visible(function (UserSubmission $record) {
                                        $getInstalment = $record->has_instalment;
                                        return $getInstalment === 1 ? true : false;
                                    })
                                    ->prefix('Rp.')
                                    ->mask(RawJs::make('$money($input)')),
                                TextInput::make('type')
                                    ->default(fn(UserSubmission $record): string => $record->incomes[0]->type === 'self' ? 'Pribadi' : 'Join Income')
                                    ->readOnly()
                                    ->columnSpan(2)
                                    ->label('Tipe Penghasilan'),

                                Repeater::make('Income')
                                    ->label('Penghasilan')
                                    ->disableItemDeletion()
                                    ->disableItemCreation()
                                    ->disableItemMovement()
                                    ->columnSpan(2)
                                    ->schema(fn(UserSubmission $record) => $record ? static::getIncome($record) : []),
                            ])->columns(2)
                        ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
            
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserSubmissions::route('/'),
            'create' => Pages\CreateUserSubmissions::route('/create'),
            'edit' => Pages\EditUserSubmissions::route('/{record}/edit'),
        ];
    }
}
