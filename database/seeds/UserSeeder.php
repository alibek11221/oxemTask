<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['name' => 'User', 'email' => 'example@gmail.com'],
            ['password' => Hash::make('password')]
        );
    }
}
