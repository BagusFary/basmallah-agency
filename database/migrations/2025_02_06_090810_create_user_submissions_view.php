<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        CREATE VIEW user_submissions_view AS
            SELECT
            us.id AS user_submission_id,
            us.housing_partner_id,
            us.email,
            us.phone,
            us.NAME AS submission_name,
            us.id_card,
            us.address,
            us.employment_status,
            us.self_employee_as,
            us.avg_monthly_turnover,
            us.has_instalment,
            us.instalment_amount,
            us.referral_code,
            us.created_at,
            us.updated_at,
            MAX( CASE WHEN i.type = 'join-husband' THEN i.salary ELSE 0 END ) AS join_husband_income,
            MAX( CASE WHEN i.type = 'join-wife' THEN i.salary ELSE 0 END ) AS join_wife_income,
            SUM(
            CASE
                    
                    WHEN i.type IN ( 'join-husband', 'join-wife' ) THEN
                    i.salary 
                    WHEN i.type = 'self' THEN
                    i.salary -- Tambahkan self_income ke total
                    ELSE 0 
                END 
                ) AS total_salary,
                MAX( CASE WHEN i.type = 'self' THEN i.salary ELSE 0 END ) AS self_income,
                hp.NAME AS housing_partner_name,
            CASE
                    
                    WHEN MAX( CASE WHEN i.type = 'self' THEN 1 ELSE 0 END ) = 1 THEN
                        'Self Income' 
                        WHEN MAX( CASE WHEN i.type IN ( 'join-husband', 'join-wife' ) THEN 1 ELSE 0 END ) = 1 THEN
                            'Joint Income' ELSE NULL -- Atau nilai lain yang sesuai jika tidak ada 'self' atau 'join'
                            
                        END AS income_type 
                    FROM
                        user_submissions us
                        INNER JOIN incomes i ON us.id = i.user_submission_id
                        INNER JOIN housing_partners hp ON us.housing_partner_id = hp.id 
                    GROUP BY
                        us.id,
                        us.housing_partner_id,
                        us.email,
                        us.phone,
                        us.NAME,
                        us.id_card,
                        us.address,
                        us.employment_status,
                        us.self_employee_as,
                        us.avg_monthly_turnover,
                        us.has_instalment,
                        us.instalment_amount,
                        us.referral_code,
                        us.created_at,
                    us.updated_at,
            hp.NAME;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW user_submissions_view");
    }
};
