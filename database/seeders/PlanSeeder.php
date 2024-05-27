<?php

namespace Database\Seeders;

use App\Enums\PlanBillingIntervalEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!count(DB::table('plans')->where('name', 'Basic')->get())) {
            DB::table('plans')->insert([
                'name' => 'Basic',
                'description' => 'Plano básico.',
                'price' => 39.9,
                'trial_days' => 30,
                'billing_interval' => PlanBillingIntervalEnum::Monthly,
                'bank_gateway_id' => 'PLAN_258FFF5F-9E15-4EEA-9FDE-8366636A4854'
            ]);
        }
        
        if (!count(DB::table('plans')->where('name', 'Popular')->get())) {
            DB::table('plans')->insert([
                'name' => 'Popular',
                'description' => 'Plano avançado.',
                'price' => 79.9,
                'trial_days' => 30,
                'billing_interval' => PlanBillingIntervalEnum::Monthly,
                'bank_gateway_id' => ''
            ]);
        }

        if (!count(DB::table('plans')->where('name', 'Enterprise')->get())) {
            DB::table('plans')->insert([
                'name' => 'Enterprise',
                'description' => 'Plano empresarial.',
                'price' => 119.9,
                'trial_days' => 30,
                'billing_interval' => PlanBillingIntervalEnum::Monthly,
                'bank_gateway_id' => ''
            ]);
        }
    }
}
