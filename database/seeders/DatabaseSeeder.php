<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        for ($i=0; $i < 20; $i++) { 
            DB::table('users')->insert([
                'name' => 'guess'.$i,
                'email' => 'guess'.$i.'@gmail.com',
                'role' => 'user',
                'password' => Hash::make('password'),
            ]);
        }
        // \App\Models\User::factory(10)->create();
    }
}
