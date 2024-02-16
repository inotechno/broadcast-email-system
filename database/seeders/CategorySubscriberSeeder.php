<?php

namespace Database\Seeders;

use App\Models\CategorySubscriber;
use Illuminate\Database\Seeder;

class CategorySubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategorySubscriber::create([
            'name' => 'Test',
            'description' => 'Category untuk test pengiriman email'
        ]);
    }
}
