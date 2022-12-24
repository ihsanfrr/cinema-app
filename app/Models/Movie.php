<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function purchase(){
        return $this->hasMany(Purchase::class);
    }
}
