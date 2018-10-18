<?php

use Illuminate\Database\Seeder;

class DirectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Director::class, 20)->create();
    }
}
