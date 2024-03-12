<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Admin\StockSeeder;
use Database\Seeders\Admin\PlatformSeeder;
use Database\Seeders\Admin\InvestmentSeeder;
use Database\Seeders\Admin\PlatformTypesSeeder;
use Database\Seeders\Admin\InvestmentTypeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Brijeshdev',
            'email' => 'brijesh_dev@test.com',
            'password' => bcrypt('test')
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Brijesh',
            'email' => 'brijesh@test.com',
            'password' => bcrypt('test')
        ]);
        
        $this->call(PermissionSeeder::class);


        $this->call(PlatformTypesSeeder::class);
        $this->call(PlatformSeeder::class);
        $this->call(StockSeeder::class);
        // $this->call(InvestmentTypeSeeder::class);
        // $this->call(InvestmentSeeder::class);

    }
}
