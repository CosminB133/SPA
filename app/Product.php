<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'description', 'price',
    ];

    public $timestamps = false;

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }
}
