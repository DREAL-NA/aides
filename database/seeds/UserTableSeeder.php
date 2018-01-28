<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        \App\User::create([
            'id' => 1,
            'name' => 'Nicolas Giraud',
            'email' => 'contact@ngiraud.me',
            'password' => Hash::make('password'),
        ]);
    }
}
