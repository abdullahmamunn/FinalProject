<?php

use Illuminate\Database\Seeder;
use App\Model\Menu;
class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::truncate();
        Menu::insert(
            [
                //1 Manage Role
                ['id' => 1, 'parent_id' => 0,'action'=>NULL,'name'  => 'Manage Role', 'menu_url'  => NULL, 'module_id'  => '1', 'status'  => '1','module_group_id'=>'1.01'],
                ['id' => 2, 'parent_id' => 1,'action'=>NULL,'name'  => 'Add Role', 'menu_url'  => 'role.create', 'module_id'  => '1', 'status'  => '1','module_group_id'=>'1.02'],
                ['id' => 3, 'parent_id' => 2,'action'=> 2,'name'  => 'Add', 'menu_url'  => 'role.store', 'module_id'  => '1', 'status'  => '1','module_group_id'=>'1.03'],
                ['id' => 4, 'parent_id' => 2,'action'=> 2,'name'  => 'Edit', 'menu_url'  => 'role.edit', 'module_id'  => '1', 'status'  => '1','module_group_id'=>'1.04'],
                ['id' => 5, 'parent_id' => 2,'action'=> 2,'name'  => 'Delete', 'menu_url'  => 'role.destroy', 'module_id'  => '1', 'status'  => '1','module_group_id'=>'1.05'],

                //6 Role Permission
                ['id' => 6, 'parent_id' => 1,'action'=>NULL,'name'  => 'Role Permission', 'menu_url'  => 'permission.index', 'module_id'  => '1', 'status'  => '1','module_group_id'=>'1.05'],
                //7 Add User
                ['id' => 7, 'parent_id' => 0,'action'=>NULL,'name'  => 'User List', 'menu_url'  => 'user-registration.create', 'module_id'  => '1', 'status'  => '1','module_group_id'=>'1.06'],
                ['id' => 8, 'parent_id' => 7,'action'=>7,'name'  => 'Add', 'menu_url'  => 'user-registration.store', 'module_id'  => '1', 'status'  => '1','module_group_id'=>'1.07'],
                ['id' => 9, 'parent_id' => 7,'action'=>7,'name'  => 'Edit', 'menu_url'  => 'user-registration.edit', 'module_id'  => '1', 'status'  => '1','module_group_id'=>'1.08'],
                ['id' => 10, 'parent_id' => 7,'action'=>7,'name'  => 'Delete', 'menu_url'  => 'user-registration.destroy', 'module_id'  => '1', 'status'  => '1','module_group_id'=>'1.09'],

                // Mess Meal Menus
                ['id' => 11, 'parent_id' => 0,'action'=>NULL,'name'  => 'Meal Dashboard', 'menu_url'  => 'mess-meal.overview', 'module_id'  => '2', 'status'  => '1','module_group_id'=>'2.01'],

                ['id' => 12, 'parent_id' => 0,'action'=>NULL,'name'  => 'Members', 'menu_url'  => 'mess-member.index', 'module_id'  => '3', 'status'  => '1','module_group_id'=>'3.01'],
                ['id' => 13, 'parent_id' => 12,'action'=>12,'name'  => 'Add', 'menu_url'  => 'mess-member.store', 'module_id'  => '3', 'status'  => '1','module_group_id'=>'3.02'],
                ['id' => 14, 'parent_id' => 12,'action'=>12,'name'  => 'Edit', 'menu_url'  => 'mess-member.edit', 'module_id'  => '3', 'status'  => '1','module_group_id'=>'3.03'],
                ['id' => 15, 'parent_id' => 12,'action'=>12,'name'  => 'Delete', 'menu_url'  => 'mess-member.destroy', 'module_id'  => '3', 'status'  => '1','module_group_id'=>'3.04'],

                ['id' => 16, 'parent_id' => 0,'action'=>NULL,'name'  => 'Markets', 'menu_url'  => 'market.index', 'module_id'  => '2', 'status'  => '1','module_group_id'=>'2.02'],
                ['id' => 17, 'parent_id' => 16,'action'=>16,'name'  => 'Add', 'menu_url'  => 'market.store', 'module_id'  => '2', 'status'  => '1','module_group_id'=>'2.03'],
                ['id' => 18, 'parent_id' => 16,'action'=>16,'name'  => 'Edit', 'menu_url'  => 'market.edit', 'module_id'  => '2', 'status'  => '1','module_group_id'=>'2.04'],
                ['id' => 19, 'parent_id' => 16,'action'=>16,'name'  => 'Delete', 'menu_url'  => 'market.destroy', 'module_id'  => '2', 'status'  => '1','module_group_id'=>'2.05'],

                ['id' => 20, 'parent_id' => 0,'action'=>NULL,'name'  => 'Meals', 'menu_url'  => 'meal.index', 'module_id'  => '2', 'status'  => '1','module_group_id'=>'2.06'],
                ['id' => 21, 'parent_id' => 20,'action'=>20,'name'  => 'Add', 'menu_url'  => 'meal.store', 'module_id'  => '2', 'status'  => '1','module_group_id'=>'2.07'],
                ['id' => 22, 'parent_id' => 20,'action'=>20,'name'  => 'Edit', 'menu_url'  => 'meal.edit', 'module_id'  => '2', 'status'  => '1','module_group_id'=>'2.08'],
                ['id' => 23, 'parent_id' => 20,'action'=>20,'name'  => 'Delete', 'menu_url'  => 'meal.destroy', 'module_id'  => '2', 'status'  => '1','module_group_id'=>'2.09'],

                ['id' => 24, 'parent_id' => 0,'action'=>NULL,'name'  => 'Balance', 'menu_url'  => 'balance.index', 'module_id'  => '2', 'status'  => '1','module_group_id'=>'2.10'],
                ['id' => 25, 'parent_id' => 24,'action'=>24,'name'  => 'Add', 'menu_url'  => 'balance.store', 'module_id'  => '2', 'status'  => '1','module_group_id'=>'2.11'],
                ['id' => 26, 'parent_id' => 24,'action'=>24,'name'  => 'Edit', 'menu_url'  => 'balance.edit', 'module_id'  => '2', 'status'  => '1','module_group_id'=>'2.12'],
                ['id' => 27, 'parent_id' => 24,'action'=>24,'name'  => 'Delete', 'menu_url'  => 'balance.destroy', 'module_id'  => '2', 'status'  => '1','module_group_id'=>'2.13'],

                ['id' => 28, 'parent_id' => 0,'action'=>NuLL,'name'  => 'Setting', 'menu_url'  => 'setting.index', 'module_id'  => '4', 'status'  => '1','module_group_id'=>'4.01'],
            ]
        );

    }
}
