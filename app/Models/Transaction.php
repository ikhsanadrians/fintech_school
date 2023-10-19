<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        "users_id", "products_id", "status", "order_code", "price", "quantity"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "id");
    }

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function userTransactions()
    {
        return $this->belongsToMany(User::class, "user_transactions");
    }
}
