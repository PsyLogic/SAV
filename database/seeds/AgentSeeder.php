<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "Walid STG",
            'username' =>"admin",
            'email' => "",
            'type' => 'admin',
            'password' => Hash::make('123456'),
        ]);
        User::create([
            'name' => "Ahmed kiki",
            'username' =>"commercial",
            'email' => "",
            'type' => 'Commercial',
            'password' => Hash::make('123456'),
        ]);
        
        User::create([
            'name' => "Zakaria Kacem",
            'username' =>"sav",
            'email' => "",
            'type' => 'SAV',
            'password' => Hash::make('123456'),
        ]);
    }
}
