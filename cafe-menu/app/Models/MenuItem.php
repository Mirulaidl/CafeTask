<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = ['meal_id', 'name', 'image', 'category', 'area', 'instructions', 'ingredients', 'price', 'status'];

    protected $casts = ['ingredients' => 'array', 'price' => 'decimal:2'];
}
