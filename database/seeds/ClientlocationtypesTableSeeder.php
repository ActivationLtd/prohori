<?php

use Illuminate\Database\Seeder;

class ClientlocationtypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Bank',
            'ATM',
            'Hospital',
            'Educational institution',
            'Construction site',
            'Office',
            'Hotel/Restaurant',
            'Event',
        ];

        foreach ($names as $name) {
            if (\App\Clientlocationtype::where('name', $name)->doesntExist()) {
                \App\Clientlocationtype::create([
                    'name' => $name,
                ]);
            }
        }
    }
}
