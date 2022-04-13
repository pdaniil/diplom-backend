<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Orders;
use App\Models\Customers;
use App\Models\OrdersStatuses;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $status = OrdersStatuses::factory()->create();

        $customer = Customers::factory(10)
                ->has
                (
                    Orders::factory(3)->for($status, 'status')
                )
                ->create();
    }
}
