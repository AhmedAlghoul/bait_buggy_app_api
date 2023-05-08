<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['image'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'product_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'category_id', 'id');
    }
}
