<?php

use Illuminate\Database\Seeder;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new \App\Models\Role();
        $role->name = "admin";
        $role->display_name = "Super Admin";
        $role->description  = 'User is the Super Admin with global access';
        $role->save();

        $role = new \App\Models\Role();
        $role->name = "vendor";
        $role->display_name = "Vendor";
        $role->description  = 'User is an Admin with limited permissions';
        $role->save();

        $role = new \App\Models\Role();
        $role->name = "agent";
        $role->display_name = "Delivery Agent";
        $role->description  = 'User is an agent';
        $role->save();

        $role = new \App\Models\Role();
        $role->name = "customer";
        $role->display_name = "Learner";
        $role->description  = 'User is a learner';
        $role->save();
    }
}
