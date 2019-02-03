<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'superuser';
        if (\App\User::where('name', $name)->doesntExist()) {
            \App\User::create([
                'name' => $name,
                'email' => "{$name}@gmail.com",
                'password' => Hash::make('activation')
            ]);
        }
    }
}
