<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'comment', 'rating',
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
