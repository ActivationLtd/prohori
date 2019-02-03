<?php

use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $names = ['modules', 'modulegroups', 'tenants', 'users', 'groups'];

        foreach ($names as $name) {
            /** @var \App\Basemodule $Model */
            //$Model = model($name);
            if (\App\Module::where('name', $name)->doesntExist()) {
                \App\Module::create([
                    'name' => $name,
                    'title' => ucfirst(str_singular($name)),
                    'description' => 'Manage ' . str_singular($name),
                ]);
            }
        }
    }
}
