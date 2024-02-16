<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Subscriber1 = Subscriber::create([
            'uuid' => Str::random(15),
            'email' => 'ahmad.fatoni@mindotek.com',
            'name' => 'Ahmad Fatoni',
            'active' => 1
        ]);

        $Subscriber1->categories()->sync(1);

        $Subscriber2  = Subscriber::create([
            'uuid' => Str::random(15),
            'email' => 'badrus.sholeh@mindotek.com',
            'name' => 'Badrus Sholeh',
            'active' => 1
        ]);

        $Subscriber2->categories()->sync(1);

        $Subscriber3  = Subscriber::create([
            'uuid' => Str::random(15),
            'email' => 'info@rumahaplikasi.co.id',
            'name' => 'Rumah Aplikasi',
            'active' => 1
        ]);

        $Subscriber3->categories()->sync(1);
    }
}
