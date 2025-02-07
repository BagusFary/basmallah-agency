<?php

namespace App\Exports;

use App\Models\UserSubmission;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\Database\Query\Builder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserSubmissionsExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = DB::table('user_submissions_view')
                        ->when(isset($this->request['user_submission_id']), function (Builder $query) {
                            $query->whereIn('user_submission_id', $this->request['user_submission_id']);
                        })
                        ->when(isset($this->request['housing_partner_id']), function (Builder $query) {
                            $query->where('housing_partner_id', $this->request['housing_partner_id']);
                        })
                        ->when(isset($this->request['employment_status']), function (Builder $query) {
                            $query->where('employment_status', $this->request['employment_status']);
                        })
                        ->when(isset($this->request['avg_monthly_turnover']), function (Builder $query) {
                            $query->whereBetween('avg_monthly_turnover', [$this->request['avg_turnover_min'], $this->request['avg_turnover_max']]);
                        })
                        ->when(isset($this->request['has_instalment']), function (Builder $query) {
                            $query->where('has_instalment', $this->request['has_instalment']);
                        })
                        ->when(isset($this->request['instalment_amount']), function (Builder $query) {
                            $query->whereBetween('instalment_amount', [$this->request['instalment_amount_min'], $this->request['instalment_amount_max']]);
                        })
                        ->when(isset($this->request['created_at']), function (Builder $query) {
                            $dates = explode(' - ', $this->request['created_at']);
                            $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                            $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                            $query->whereBetween('created_at', [$startDate, $endDate]);
                        })
                        ->when(isset($this->request['income_type']), function (Builder $query) {
                            $query->where('income_type', $this->request['income_type']);
                        })
                        ->when(isset($this->request['salary_min']), function (Builder $query) {
                            $query->where('total_salary', '>=', $this->request['salary_min']);
                        })
                        ->when(isset($this->request['salary_max']), function (Builder $query) {
                            $query->where('total_salary', '<=', $this->request['salary_max']);
                        });

        return $data->get();

    }

    public function headings() :array
    {
        return [
            'Kode Referral',
            'Housing Partner',
            'Nama',
            'Nomor Whatsapp',
            'Alamat',
            'NIK',
            'Email',
            'Status Pekerjaan',
            'Bidang Wirausaha',
            'Omset Rata-Rata',
            'Tipe Penghasilan',
            'Penghasilan Pribadi',
            'Penghasilan Suami',
            'Penghasilan Istri',
            'Total Penghasilan',
            'Cicilan',
            'Jumlah Cicilan'
        ];
    }

    public function map($submission): array
    {
        $employmentStatus = $submission->employment_status;

        switch ($employmentStatus) {
            case 'self_employees':
                $employmentStatus = 'Wirausaha';
                break;
            case 'civil_servant':
                $employmentStatus = 'PNS';
                break;
            case 'employees':
                $employmentStatus = 'Pegawai Swasta';
                break;
        }

        $hasInstalment = $submission->has_instalment;

        switch ($hasInstalment){
            case 0:
                $hasInstalment = 'Tidak Ada';
                break;
            case 1:
                $hasInstalment = 'Ada';
                break;
        }

        return [
            $submission->referral_code,
            $submission->housing_partner_name,
            $submission->submission_name,
            $submission->phone,
            $submission->address,
            $submission->id_card,
            $submission->email,
            $employmentStatus,
            $submission->self_employee_as ?? '-',
            $submission->avg_monthly_turnover == 0 ? '-' : $submission->avg_monthly_turnover,
            $submission->income_type,
            $submission->self_income == 0 ? '-' : $submission->self_income,
            $submission->join_husband_income == 0 ? '-' : $submission->join_husband_income,
            $submission->join_wife_income == 0 ? '-' : $submission->join_wife_income,
            $submission->total_salary == 0 ? $submission->self_income : $submission->total_salary,
            $hasInstalment,
            $submission->instalment_amount == 0 ? '-' : $submission->instalment_amount,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow() => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
            'A1:Q1' => ['font' => [
                'bold' => true,
                'size' => 12
                ]
            ]
        ];
    }
}
