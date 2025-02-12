<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Income;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use App\Models\HousingPartner;
use App\Models\UserSubmission;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Radio;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Cache;
use App\Exports\UserSubmissionsExport;
use Filament\Forms\Components\Section;
use Filament\Tables\Filters\Indicator;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\UserSubmissionsResource\Pages;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;
use App\Filament\Resources\UserSubmissionResource\Widgets\StatsOverview;
use App\Filament\Resources\UserSubmissionsResource\Widgets\StatsOverview as WidgetsStatsOverview;

class UserSubmissionsResource extends Resource
{
    protected static ?string $model = UserSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

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
            ->modifyQueryUsing(fn(Builder $query) => $query->latest())
            ->columns([
                TextColumn::make('housingPartner.name')
                    ->label('Perumahan')
                    ->searchable(),
                TextColumn::make('referral_code')
                    ->label('Kode Referral')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Nomor WhatsApp')
                    ->searchable(),

            ])
            ->filters([
                Filter::make('has_instalment')
                    ->label('Punya Cicilan?')
                    ->form([
                        DateRangePicker::make('createdAt')
                            ->label('Rentang Tanggal')
                            ->placeholder('Pilih Rentang Tanggal'),
                        Radio::make('isCicilan')
                            ->options([
                                '1' => 'Punya',
                                '0' => 'Tidak Punya'
                            ])
                            ->columns(2)
                            ->label('Cicilan?')
                            ->afterStateUpdated(function (?string $state, Set $set) {
                                if ($state == '0') {
                                    $set('minCicilan', null);
                                    $set('maxCicilan', null);
                                }
                            })
                            ->live(),
                        Section::make('Cicilan')
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
                            ->visible(function (Get $get) {
                                return $get('isCicilan') ?? false;
                            })
                            ->columns(2)
                    ])
                    ->indicateUsing(function ($data) {
                        $indicator = [];

                        if (isset($data['isCicilan'])) {
                            $text = $data['isCicilan'] ? 'Punya' : 'Tidak Punya';
                            $indicator[] = Indicator::make("$text Cicilan")
                                // ->removeField('isCicilan')
                                ->removable(false);
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
                        $query->when(isset($data['isCicilan']), function (Builder $query, $hasInstalment) use ($data) {
                            $query->where('has_instalment', $data['isCicilan']);

                            $query->when($data['isCicilan'] == '1', function (Builder $query) use ($data) {
                                $query->when($data['minCicilan'] ?? null, function ($query, $minCicilan) {
                                    $minCicilan = str_replace([','], '', $minCicilan ?? null);

                                    $query->where('instalment_amount', '>=', $minCicilan);
                                });
                                $query->when($data['maxCicilan'] ?? null, function ($query, $maxCicilan) {
                                    $maxCicilan = str_replace([','], '', $maxCicilan ?? null);

                                    $query->where('instalment_amount', '<=', $maxCicilan);
                                });
                            });
                        });

                        $query->when(isset($data['createdAt']), function (Builder $query) use ($data) {
                            $dates = explode(' - ', $data['createdAt']);
                            $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                            $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                            $query->whereBetween('created_at', [$startDate, $endDate]);
                        });

                        return $query;
                    })
                    ->columns(2)
                    ->columnSpanFull(),
                SelectFilter::make('housing_partner_id')
                    ->relationship(name: 'housingPartner', titleAttribute: 'name')
                    ->native(false)
                    ->label('Perumahan'),
                SelectFilter::make('employment_status')
                    ->options([
                        'self_employees' => 'Wirausaha',
                        'civil_servants' => 'PNS',
                        'employees' => 'Karyawan'
                    ])
                    ->native(false)
                    ->label('Status Pekerjaan'),
                Filter::make('incomes.salary')
                    ->form([
                        Section::make('Penghasilan')
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
                            ])
                            ->columns(2),
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

                        return $indicator;
                    })
                    ->query(function (Builder $query, array $data) {
                        $minSalary = str_replace([','], '', $data['minSalary'] ?? null);
                        $maxSalary = str_replace([','], '', $data['maxSalary'] ?? null);
                        return
                            $query
                            ->when($minSalary ?? null, function ($query, $minSalary) {
                                return $query->whereHas('incomes', function ($q) use ($minSalary) {
                                    $q->where('salary', '>=', $minSalary);
                                });
                            })
                            ->when($maxSalary ?? null, function ($query, $maxSalary) {
                                return $query->whereHas('incomes', function ($q) use ($maxSalary) {
                                    $q->selectRaw('SUM(salary) as total_salary')->having('total_salary', '<=', $maxSalary);
                                });
                            });
                    })
                    ->columnSpanFull()
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->filtersFormColumns(2)
            ->deferLoading()
            ->headerActions([
                Action::make('exportGlobal')
                    ->label('Export Excel')
                    ->icon('heroicon-m-folder-arrow-down')
                    ->form([
                        Section::make('Filter Export User Submission')
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
                                        'employees' => 'Pegawai Swasta',
                                    ])
                                    ->native(false)
                                    ->live(),
                                Section::make('Omset Rata - Rata Perbulan')
                                    ->schema([
                                        TextInput::make('avg_turnover_min')
                                            ->label('Minimal')
                                            ->placeholder('Masukkan Omset Minimal')
                                            ->inputMode('numeric')
                                            ->minValue(0)
                                            ->numeric()
                                            ->prefix('Rp.')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(','),
                                        TextInput::make('avg_turnover_max')
                                            ->label('Maksimal')
                                            ->placeholder('Masukkan Omset Maksimal')
                                            ->inputMode('numeric')
                                            ->minValue(0)
                                            ->numeric()
                                            ->prefix('Rp.')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(',')
                                            ->gt('avg_turnover_min'),
                                        ])
                                        ->columns(2)
                                        ->visible(fn ($get) => $get('employment_status') === 'self_employees'),
                                    Radio::make('has_instalment')
                                        ->label('Punya Cicilan')
                                        ->options([
                                            "1" => 'Ya',
                                            "0" => 'Tidak'
                                        ])
                                        ->inline()
                                        ->inlineLabel(false)
                                        ->live(),
                                        Section::make('Jumlah Cicilan')
                                        ->schema([
                                            TextInput::make('instalment_amount_min')
                                            ->label('Minimal')
                                            ->placeholder('Masukkan Minimal Cicilan')
                                            ->inputMode('numeric')
                                            ->minValue(0)
                                            ->numeric()
                                            ->prefix('Rp.')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(','),
                                        TextInput::make('instalment_amount_max')
                                            ->label('Maksimal')
                                            ->placeholder('Masukkan Maksimal Cicilan')
                                            ->inputMode('numeric')
                                            ->minValue(0)
                                            ->numeric()
                                            ->prefix('Rp.')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(',')
                                            ->gt('instalment_amount_min'),
                                    ])
                                    ->columns(2)
                                    ->visible(fn($get) => $get('has_instalment') === '1'),
                                Select::make('income_type')
                                    ->label('Tipe Penghasilan')
                                    ->placeholder('Pilih Tipe Penghasilan')
                                    ->options([
                                        'Self Income' => 'Pribadi',
                                        'Joint Income' => 'Joint Income'
                                    ])
                                    ->native(false)
                                    ->live(),
                                Section::make('Penghasilan')
                                    ->schema([
                                        TextInput::make('salary_min')
                                            ->label('Minimal')
                                            ->placeholder('Masukkan Minimal Penghasilan')
                                            ->inputMode('numeric')
                                            ->minValue(0)
                                            ->numeric()
                                            ->prefix('Rp.')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(','),
                                        TextInput::make('salary_max')
                                            ->label('Maksimal')
                                            ->placeholder('Masukkan Maksimal Penghasilan')
                                            ->inputMode('numeric')
                                            ->minValue(0)
                                            ->numeric()
                                            ->prefix('Rp.')
                                            ->mask(RawJs::make('$money($input)'))
                                            ->stripCharacters(',')
                                            ->gt('salary_min'),
                                        ])
                                        ->columns(2)
                                ])
                                ->columns(2)
                        ])
                        ->action( function(array $data){
                            return Excel::download(new UserSubmissionsExport($data), 'Rekap User Submission - ' . now()->format('Ymd_His') . '.xlsx');
                        })
                        ->modalSubmitActionLabel('Export')
                        ->modalCancelActionLabel('Batal')
            ])
            ->actions([
                Tables\Actions\Action::make('detail')
                ->iconButton()
                ->icon('heroicon-s-eye')
                ->color('info')
                ->tooltip('Detail')
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
                                    ->deletable(false)
                                    ->addable(false)
                                    ->reorderable(false)
                                    ->columnSpan(2)
                                    ->schema(fn(UserSubmission $record) => $record ? static::getIncome($record) : []),
                            ])->columns(2)
                                ]),
                Tables\Actions\EditAction::make()
                ->iconButton()
                ->tooltip('Edit'),
                Tables\Actions\DeleteAction::make()
                ->iconButton()
                ->icon('heroicon-s-trash')
                ->color('danger')
                ->tooltip('Delete')
                ->action(function (UserSubmission $record){
                    Income::where('user_submission_id', $record->id)->delete();
                    $query = UserSubmission::where('id', $record->id);
                    $query->first()->housingPartner()->increment('available');
                    $query->delete();

                    Notification::make()
                    ->title('Delete Success')
                    ->success()
                    ->body('The record has been successfully deleted.')
                    ->send();
                })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $ids = $records->pluck('id');
                            $housePartnerIds = $records->pluck('housing_partner_id')->toArray();
                            $bulkData = array_count_values($housePartnerIds);

                            foreach ($bulkData as $housingPartnerId => $count) {
                                HousingPartner::where('id', $housingPartnerId)->increment('available', $count);
                            }

                            // HousingPartner::whereIn('id', $housePartnerIds)->increment('available');
                            Income::whereIn('user_submission_id', $ids)->delete();
                            UserSubmission::whereIn('id', $ids)->delete();
                        })
                        ->after(fn() => Cache::forget('index-housing-list'))
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('exportBulk')
                        ->requiresConfirmation()
                        ->label('Export Excel')
                        ->icon('heroicon-m-folder-arrow-down')
                        ->action(function (Collection $records) {

                            $data = [
                                'user_submission_id' => $records->pluck('id')
                            ];

                            return Excel::download(new UserSubmissionsExport($data), 'RekapitulasiForm-' . now()->format('Ymd_His') . '.xlsx');
                        })
                ]),
            ])
            ->paginated([10, 25, 50, 100]);
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
            'edit' => Pages\EditUserSubmissions::route('/{record}/edit'),
        ];
    }
}
