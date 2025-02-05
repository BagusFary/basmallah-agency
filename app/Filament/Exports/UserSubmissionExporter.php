<?php

namespace App\Filament\Exports;

use App\Models\UserSubmission;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class UserSubmissionExporter extends Exporter
{
    protected static ?string $model = UserSubmission::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('housingPartner.name')
                ->label('Housing Partner'),
            ExportColumn::make('email')
                ->label('Email'),
            ExportColumn::make('phone')
                ->label('Nomor Whatsapp'),
            ExportColumn::make('name')
                ->label('Nama'),
            ExportColumn::make('id_card')
                ->label('NIK'),
            ExportColumn::make('address')
                ->label('Alamat'),
            ExportColumn::make('employment_status')
                ->label('Status Pekerjaan'),
            ExportColumn::make('self_employee_as')
                ->label('Bidang Wirausaha'),
            ExportColumn::make('incomes.type')
                ->label('Tipe Penghasilan'),
            // ExportColumn::make('incomes.salary')
            //     ->label('Jumlah Penghasilan'),
            ExportColumn::make('avg_monthly_turnover')
                ->label('Omset Rata Rata Perbulan'),
            ExportColumn::make('has_instalment')
                ->label('Status Cicilan'),
            ExportColumn::make('instalment_amount')
                ->label('Jumlah Cicilan'),
            ExportColumn::make('referral_code')
                ->label('Kode Referral'),
            ExportColumn::make('created_at')
                ->label('Dibuat pada'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your user submission export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    
}
