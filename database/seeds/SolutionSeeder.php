<?php

use Illuminate\Database\Seeder;
use App\Solution;

class SolutionSeeder extends Seeder
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
            Solution::create([
                'content' => "Solution " . $i,
            ]);
        }
    }
}
