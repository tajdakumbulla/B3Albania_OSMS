<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Cart;
use App\User;
use App\Category;
use App\Favorite;
use App\Order;
use App\OrderProduct;
use App\ProductCategory;
use App\ProductImage;
use App\Review;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        // $this->call(UsersTableSeeder::class);
        User::create([
            "email" => "admin@admin.com",
            "password" => bcrypt("admin123"),
            "full_name" => "admin",
            "phone" => "+35569696969",
            "user_level" => 3,
            "lat" => "41.3275",
            "lng" => "19.818700000000035",
            "postal_code" => "1000",
            "verified" => 1
        ]);
        User::create([
            "email" => "manager@manager.com",
            "password" => bcrypt("manager123"),
            "full_name" => "manager",
            "phone" => "+35569696969",
            "user_level" => 2,
            "lat" => "41.3275",
            "lng" => "19.818700000000035",
            "postal_code" => "1000",
            "verified" => 1
        ]);
        User::create([
            "email" => "user@user.com",
            "password" => bcrypt("user123"),
            "full_name" => "user",
            "phone" => "+35569696969",
            "user_level" => 1,
            "lat" => "41.3275",
            "lng" => "19.818700000000035",
            "postal_code" => "1000",
            "verified" => 1
        ]);

        DB::table("status")->insert([
            "title" => "Received"
        ]);
        DB::table("status")->insert([
            "title" => "Processing"
        ]);
        DB::table("status")->insert([
            "title" => "In Delivery"
        ]);
        DB::table("status")->insert([
            "title" => "Completed"
        ]);
        DB::table("status")->insert([
            "title" => "Rejected"
        ]);
        DB::table("status")->insert([
            "title" => "Deleted"
        ]);
    }
}
