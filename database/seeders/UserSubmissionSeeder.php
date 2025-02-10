<?php

namespace Database\Seeders;

use App\Models\UserSubmission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $housePartners = DB::table('housing_partners')->get(['id'])->pluck('id')->toArray();
        for ($i = 0; $i < 1000; $i++) {
            $id = array_rand($housePartners);
            $types = ['self_employees', 'civil_servants', 'employees'];
            shuffle($types);
            $data = UserSubmission::create([
                'housing_partner_id' => $housePartners[$id],
                'name' => Str::random(50),
                'phone' => rand(10000000, 99999999),
                'address' => Str::random(400),
                'email' => Str::random(30) . '@gmail.com',
                'id_card' => rand(0000001, 7654321),
                'employment_status' => $types[0],
                'self_employee_as' => Str::random(40),
                'avg_monthly_turnover' => rand(10000000, 99999999),
                'has_instalment' => 0,
                'referral_code' => Str::random(60),
            ]);

            $data->incomes()->create([
                'type' => 'self',
                'salary' => 3000000
            ]);
        }
    }
}
