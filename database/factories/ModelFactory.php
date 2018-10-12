<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'mobile' => $faker->unique()->numberBetween(1000000000,9999999999),
        'email' => $faker->unique()->safeEmail,
        'password' => 'secret',
        'remember_token' => str_random(10),
        'fcm_token' => str_random(10),
        'api_token' => str_random(60),
    ];
});

//$factory->define(App\Models\Customer::class, function (Faker $faker) {
//    return [
//        'name' => $faker->name,
//        'dob' => $faker->date(),
//    ];
//});

$factory->define(App\Models\Vendor::class, function (Faker $faker) {
    $images = [
        'http://blog.smartd.in/wp-content/uploads/2017/03/restaurant.jpg',
        'https://www.theurbanlist.com/content/article/sydneys-best-indian-food.jpg',
        'http://www.ganges-restaurant.com/photos/haidian-restaurant/IMG_3943.JPG',
        'https://media-cdn.tripadvisor.com/media/photo-s/02/e4/63/21/spice-circle-indian-restaurant.jpg'
    ];

    return [
        'service_id' => $faker->numberBetween(1,3),
//        'service_areas' => 'Birati,Dumdum',
        'name' => $faker->name,
        'featured_image' => $images[$faker->numberBetween(0,3)],
//        'address' => $faker->address,
//        'coordinates' => '22.572646,88.36389500000001'
    ];
});

$factory->define(App\Models\Service::class, function (Faker $faker) {
    return [
        'name' => ['Restaurant','Water Supply','Cakes & Bakes'][$faker->numberBetween(0,2)],
    ];
});

$factory->define(App\Models\ItemCategory::class, function (Faker $faker) {
    return [
        'vendor_id' => $faker->numberBetween(1,10),
        'name' => $faker->name
    ];
});

$factory->define(App\Models\Item::class, function (Faker $faker) {
    return [
        'item_category_id' => $faker->numberBetween(1,10),
//        'vendor_id' => $faker->numberBetween(1,10),
        'name' => $faker->name,
        'type' => $faker->numberBetween(0,1)?'PURE_VEG':"VEG/NON_VEG",
        'featured_image' => url('api/v1/images/'.$faker->numberBetween(1,5)),
        'price' => $faker->numberBetween(100,250),
        'packing_charge' => $faker->numberBetween(0,1)?0:5
    ];
});

$factory->define(App\Models\Cuisine::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});


$factory->define(App\Models\Discount::class, function (Faker $faker){
    $expire = \Carbon\Carbon::now()->addDays(30);
    $val = $faker->numberBetween(5,10);

    return [
        'title' => "Get {$val}% Discount",
        'description' => "Get {$val}% off on selected items. Expires on {$expire->format('d/m/Y')}. T&C Apply.",
        'vendor_id' => $faker->numberBetween(1,5),
        'expires_on' => $expire,
        'featured_image' => 'http://aprcat.com/wp-content/uploads/2014/06/r1.jpg'
    ];
});

