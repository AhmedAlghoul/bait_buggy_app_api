<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsToMany(User::class, 'blocks');
    }
    // public function blockers()
    // {
    //     return $this->belongsToMany(User::class, 'blocks', 'blocked_id', 'blocker_id');
    // }
    public function blockers()
    {
        return $this->belongsTo(User::class, 'blocker_id', 'id');
    }

    public function blockedUsers()
    {
        return $this->belongsTo(User::class, 'blocked_id', 'id');
    }
}
