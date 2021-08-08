<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Todo::class)->create(10);
        \App\Models\Product::factory()->count(30)->create(); 
        //
        
        // Product::factory()->times(10)->create();
    }
}
