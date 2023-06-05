<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intro extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    // public function getImageSrcAttribute()
    // {
    //     if ($this->image_path == null) {
    //         return asset('adminassets/media/avatars/300-6.jpg');
    //     }
    //     return asset('uploads/' . $this->image_path);
    // }
}
