<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            "name" => "admin",
        ]);
        Role::create([
            "name" => "bank",
        ]);
        Role::create([
            "name" => "kantin",
        ]);
        Role::create([
            "name" => "siswa",
        ]);

        Category::create([
            "name" => "minuman"
        ]);
        Category::create([
            "name" => "makanan"
        ]);
        Category::create([
            "name" => "snack"
        ]);

        User::create([
            "name" => "raya",
            "password" => "123",
            "roles_id" => 1
        ]);
        User::create([
            "name" => "rizki",
            "password" => "345",
            "roles_id" => 2
        ]);
        User::create([
            "name" => "iksan",
            "password" => "678",
            "roles_id" => 3
        ]);
        User::create([
            "name" => "rapael",
            "password" => "890",
            "roles_id" => 4
        ]);

        Product::create([
            "name" => "lemon ice tea",
            "price" => 5000,
            "stock" => 100,
            "photo" => "img://tes/lemon",
            "desc" => "desc lemon es rrq lemon",
            "categories_id" => 1,
            "stand" => 2
        ]);
        Product::create([
            "name" => "bakso",
            "price" => 10000,
            "stock" => 50,
            "photo" => "img://tes/bakso",
            "desc" => "desc bakso evos bakso",
            "categories_id" => 2,
            "stand" => 1
        ]);
        Product::create([
            "name" => "risol",
            "price" => 3000,
            "stock" => 30,
            "photo" => "img://tes/risol",
            "desc" => "desc risol evos risol",
            "categories_id" => 3,
            "stand" => 1
        ]);

        Wallet::create([
            "users_id" => 4,
            "credit" => 100000,
            "debit" => NULL,
        ]);
        Wallet::create([
            "users_id" => 4,
            "credit" => NULL,
            "debit" => 15000,
        ]);

        Transaction::create([
            "users_id" => 4,
            "products_id" => 1,
            "status" => "diambil",
            "order_code" => "INV_12345",
            "price" => 5000,
            "quantity" => 1
        ]);
        Transaction::create([
            "users_id" => 4,
            "products_id" => 2,
            "status" => "diambil",
            "order_code" => "INV_12345",
            "price" => 10000,
            "quantity" => 1
        ]);
        Transaction::create([
            "users_id" => 4,
            "products_id" => 3,
            "status" => "diambil",
            "order_code" => "INV_12345",
            "price" => 3000,
            "quantity" => 2
        ]);
    }
}
