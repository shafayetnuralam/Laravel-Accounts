<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::create([
            'accounts_name' => 'ABC Corporation',
            'sector_name' => 'Manufacturing',
            'mobile_no' => '9876543210',
            'credit_limit' => 50000.00,
            'category' => 'Supplier',
            'opening_balance' => 15000.00,
            'Status' => 'Active'
        ]);

        Account::create([
            'accounts_name' => 'XYZ Traders',
            'sector_name' => 'Retail',
            'mobile_no' => '9123456789',
            'credit_limit' => 25000.00,
            'category' => 'Customer',
            'opening_balance' => 8000.00,
            'Status' => 'Active'
        ]);

        Account::create([
            'accounts_name' => 'Global Services Ltd',
            'sector_name' => 'Services',
            'mobile_no' => '8765432109',
            'credit_limit' => 75000.00,
            'category' => 'Supplier',
            'opening_balance' => 25000.00,
            'Status' => 'Active'
        ]);

        Account::create([
            'accounts_name' => 'Local Shop',
            'sector_name' => 'Retail',
            'mobile_no' => '7654321098',
            'credit_limit' => 10000.00,
            'category' => 'Customer',
            'opening_balance' => 3000.00,
            'Status' => 'Inactive'
        ]);
    }
}
