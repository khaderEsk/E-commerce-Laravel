<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name',
        'category',
        'oldPrice',
        'newPrice',
        'img',
        'description',
        'isFeatured'

    ];
}
