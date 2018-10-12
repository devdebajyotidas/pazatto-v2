<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(LaratrustSeeder::class);

        $admin = factory(App\Models\User::class)->make();
        $admin->account_id = 0;
        $admin->account_type = "App\\Models\\Admin";
        $admin->email = 'admin@pazatto.com';
        $admin->save();
        if($admin){
            $admin->attachRole('admin');
        }

        factory(App\Models\Service::class,3)->create();

        factory(App\Models\Vendor::class, 10)->create()->each(function($v) {
//
//            $cats = factory(App\Models\ItemCategory::class,5)->create()->each(function ($cat){
//
//                $items = factory(App\Models\Item::class,10)->make();
//                $cat->items()->saveMany($items);
//            });
//
//            $v->categories()->saveMany($cats);
//
////            $v->categories()->createMany($c);
////            $v->items()->createMany($items);
//
            $u = factory(App\Models\User::class)->create();
            $u->attachRole('vendor');
            $v->user()->save($u);
        });

        factory(App\Models\Discount::class, 5)->create();
    }
}
