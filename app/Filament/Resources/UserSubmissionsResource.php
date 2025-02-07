<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\UserSubmission;
use App\Models\UserSubmissions;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserSubmissionsResource\Pages;
use App\Filament\Resources\UserSubmissionsResource\RelationManagers;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;

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
                    ->relationship('income')
                    ->defaultItems(1)
            ]);
    }

    protected static function getIncome(UserSubmission $model)
    {
        $dynamicSchemaIncome = [];
        foreach ($model->income as $income) {
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
                    ->searchable(['email', 'address', 'phone', 'name', 'id_card',]),
                TextColumn::make('name')
                    ->label('Nama'),
                TextColumn::make('email')
                    ->label('Email'),
                TextColumn::make('address')
                    ->label('Alamat')

            ])
            ->filters([
                Filter::make('income.salary')
                    ->form([
                        Section::make('Penghasilan')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                TextInput::make('minSalary')
                                    ->label('Minimal Penghasilan')
                                    ->numeric()
                                    ->prefix('Rp.')
                                    ->mask(RawJs::make('$money($input)')),
                                TextInput::make('maxSalary')
                                    ->label('Maksimal Penghasilan')
                                    ->numeric()
                                    ->prefix('Rp.')
                                    ->mask(RawJs::make('$money($input)'))
                            ]),
                        Section::make('Cicilan')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                TextInput::make('minCicilan')
                                    ->label('Minimal Cicilan')
                                    ->numeric()
                                    ->prefix('Rp.')
                                    ->mask(RawJs::make('$money($input)')),
                                TextInput::make('maxCicilan')
                                    ->label('Maksimal Cicilan')
                                    ->numeric()
                                    ->prefix('Rp.')
                                    ->mask(RawJs::make('$money($input)'))
                            ])
                    ])
                    ->indicateUsing(function (array $data): array {
                        $indicator = [];

                        if ($data['minSalary'] ?? null) {
                            $indicator[] = Indicator::make('Minimal Penghasilan: Rp. ' .  $data['minSalary'])
                                ->removeField('minSalary');
                        }

                        if ($data['maxSalary'] ?? null) {
                            $indicator[] = Indicator::make('Maksimal Penghasilan: Rp. ' . $data['maxSalary'])
                                ->removeField('maxSalary');
                        }

                        if ($data['minCicilan'] ?? null) {
                            $indicator[] = Indicator::make('Minimal Cicilan: Rp. ' . $data['minCicilan'])
                                ->removeField('minCicilan');
                        }

                        if ($data['maxCicilan'] ?? null) {
                            $indicator[] = Indicator::make('Maksimal Cicilan: Rp. ' . $data['maxCicilan'])
                                ->removeField('maxCicilan');
                        }

                        return $indicator;
                    })
                    ->query(function (Builder $query, array $data) {
                        $minSalary = str_replace([','], '', $data['minSalary'] ?? null);
                        $maxSalary = str_replace([','], '', $data['maxSalary'] ?? null);
                        $minCicilan = str_replace([','], '', $data['minCicilan'] ?? null);
                        $maxCicilan = str_replace([','], '', $data['maxCicilan'] ?? null);
                        return
                            // dd($minSalary);
                            $query
                            ->when($minSalary ?? null, function ($query, $minSalary) {
                                return $query->whereHas('income', function ($q) use ($minSalary) {
                                    $q->where('salary', '>=', $minSalary);
                                });
                            })
                            ->when($maxSalary ?? null, function ($query, $maxSalary) {
                                return $query->whereHas('income', function ($q) use ($maxSalary) {
                                    $q->selectRaw('SUM(salary) as total_salary')->having('total_salary', '<=', $maxSalary);
                                });
                            })
                            ->when($minCicilan ?? null, function ($query, $minCicilan) {
                                return $query->where('instalment_amount', '>=', $minCicilan);
                            })
                            ->when($maxCicilan ?? null, function ($query, $maxCicilan) {
                                return $query->where('instalment_amount', '<=', $maxCicilan);
                            });
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
                                    ->default(fn(UserSubmission $record): string => $record->income[0]->type === 'self' ? 'Pribadi' : 'Join Income')
                                    ->readOnly()
                                    ->columnSpan(2)
                                    ->label('Tipe Penghasilan'),

                                Repeater::make('Income')
                                    ->label('Penghasilan')
                                    ->deletable(false)
                                    ->addable(false)
                                    ->reorderable(false)
                                    ->columnSpan(2)
                                    ->schema(fn(UserSubmission $record) => $record ? static::getIncome($record) : []),
                            ])->columns(2)


                    ])
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
