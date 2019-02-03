<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['superuser'];

        foreach ($names as $name) {
            /** @var \App\Basemodule $Model */
            //$Model = model($name);
            if (\App\Group::where('name', $name)->doesntExist()) {
                \App\Group::create([
                    'name' => $name,
                    'title' => ucfirst(str_singular($name)),
                ]);
            }
        }
    }
}
