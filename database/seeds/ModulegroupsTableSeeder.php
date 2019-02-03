<?php

use Illuminate\Database\Seeder;

class ModulegroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['settings'];

        foreach ($names as $name) {
            /** @var \App\Basemodule $Model */
            //$Model = model($name);
            if (\App\Modulegroup::where('name', $name)->doesntExist()) {
                \App\Modulegroup::create([
                    'name' => $name,
                    'title' => ucfirst(str_singular($name)),
                    'description' => 'Manage ' . str_singular($name),
                ]);
            }
        }
    }
}
