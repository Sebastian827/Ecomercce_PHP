<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'id',
        'email',
    ];

    public function products() {
        
        return $this->belongsToMany(Product::class, 'orderproducts');
    }
}
