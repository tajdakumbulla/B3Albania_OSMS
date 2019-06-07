<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Product;
use App\Cart;
use App\Category;
use App\Favorite;
use App\Order;
use App\OrderProduct;
use App\ProductCategory;
use App\ProductImage;
use App\Review;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'phone' => $faker->phoneNumber,
        'birth_date' => $faker->date(),
        'user_level' => $faker->randomElement([User::CUSTOMER, User::MANAGER, User::ADMIN]),
        'image' => 'profile.png',
        'address' => $faker->address,
        'city' => $faker->city,
        'remember_token' => Str::random(10),
        'region' => $faker->text,
        'postal_code' => $faker->postcode,
        'verified' => $verified = $faker->randomElements([User::VERIFIED, User::UNVERIFIED]),
        'verification_token' => $verified == User::UNVERIFIED ? User::generate_verification_code() : ''
    ];
});

$factory->define(Product::class, function (Faker $faker) {
    return [
        'code' => Str::random(5),
        'price' => $faker->randomFloat(),
        'title' => $faker->title,
        'description' => $faker->text,
        'in_stock' => $faker->numberBetween(0, 2000)
    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->text,
    ];
});

$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'status_code' => $faker->numberBetween(1, 6),
        'description' => $faker->text,
    ];
});
