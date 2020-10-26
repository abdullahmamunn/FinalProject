<?php

use Illuminate\Database\Seeder;

use  App\Model\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::truncate();
        Module::insert(
            [
                 ['id' => 1, 'name' => 'Administration','icon_class' => 'fa fa-id-card'],
                 ['id' => 2, 'name' => 'Mess Meal','icon_class' => 'fa fa-id-card'],
                 ['id' => 3, 'name' => 'Members','icon_class' => 'fa fa-id-card'],
                 ['id' => 4, 'name' => 'Settings','icon_class' => 'ft-settings icon-left'],
            ]
        );
    }
}
