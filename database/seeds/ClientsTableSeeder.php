<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $name = 'newsuperuser';
        // if (\App\User::where('name', $name)->doesntExist()) {
        //     \App\User::create([
        //         'name' => $name,
        //         'email' => "{$name}-seed@gmail.com",
        //         'password' => Hash::make('activation'),
        //         'remember_token' => str_random(10),
        //         'email_verified_at' => now(),
        //         'group_ids_csv' => 1,
        //     ]);
        // }

        factory(App\Client::class, 10)->create();
    }
}
