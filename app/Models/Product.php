<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'title',
        'description',
        'price',
        'brand',
        'category',
        'thumbnail',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];

}
