<?php

use Illuminate\Database\Seeder;
use App\Commercial;

class CommercialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1 ; $i < 5 ; $i++ ) 
        {
            Commercial::create([
                'full_name' => "Commercial " . $i,
                'phone' => "+212 660 666 333"
            ]);
        }
    }
}
