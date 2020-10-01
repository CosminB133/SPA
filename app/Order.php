<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name', 'comments', 'contact', 'price',
    ];
    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('price');
    }
}
