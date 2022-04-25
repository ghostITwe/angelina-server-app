<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function images() {
        return $this->hasMany(Image::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')->withPivot('cost', 'quantity');
    }
}
