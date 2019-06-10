<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['item', 'description','price', 'quantity', 'product_image'];
}
