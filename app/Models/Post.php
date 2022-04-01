<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'objects';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function pictures()
    {
        return $this->belongsToMany(Picture::class, 'object_picture', 'object_id', 'picture_id');
    }

    public function information()
    {
        return $this->hasOne(Information::class, 'object_id', 'id');
    }
}
