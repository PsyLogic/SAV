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
            'name' => "adam smith",
            'username' =>"adam",
            'email' => "",
            'type' => 'Commercial',
            'password' => Hash::make('123456'),
        ]);
        
        User::create([
            'name' => "devdas khan",
            'username' =>"devdas",
            'email' => "",
            'type' => 'SAV',
            'password' => Hash::make('123456'),
        ]);
    }
}
