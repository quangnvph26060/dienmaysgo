<?php

namespace Database\Seeders;

use App\Models\SgoOrder;
use Database\Factories\OrderFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderFactory::new()->count(12)->create();
    }
}
