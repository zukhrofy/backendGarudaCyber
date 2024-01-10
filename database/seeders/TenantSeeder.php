<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder untuk Toko Kelontong
        Tenant::create([
            'name' => 'Toko Kelontong',
        ]);

        // Seeder untuk Toko Serba Ada
        Tenant::create([
            'name' => 'Toko Serba Ada',
        ]);
    }
}
