<?php

namespace App\Exports;

use App\Models\UserSubmission;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserSubmissionsExport implements FromCollection
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
        // dd($this->request);
        $data = UserSubmission::when(isset($this->request['housing_partner_id']), function (Builder $query) {
                            $query->where('housing_partner_id', $this->request['housing_partner_id']);
                        })->when(isset($this->request['employment_status']), function (Builder $query) {
                            $query->where('employment_status', $this->request['employment_status']);
                        })->when(isset($this->request['has_instalment']), function (Builder $query) {
                            $query->where('has_instalment', $this->request['has_instalment']);
                        })->when(isset($this->request['instalment_amount']), function (Builder $query) {
                            $query->where('instalment_amount', $this->request['instalment_amount']);
                        })->when(isset($this->request['created_at']), function (Builder $query) {
                            $dates = explode(' - ', $this->request['created_at']);
                            $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                            $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                            $query->whereBetween('created_at', [$startDate, $endDate]);
                        });
    

        $data = $data->get();

        return $data;
        
    }
}
