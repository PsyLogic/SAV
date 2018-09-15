<?php

use Illuminate\Database\Seeder;
use App\Problem;

class ProblemSeeder extends Seeder
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
            Problem::create([
                'content' => "Problem " . $i,
                'eligibility' => 1
            ]);

            Problem::create([
                'content' => "Hard Problem " . $i,
                'eligibility' => 0
            ]);
        }
    }
}
