<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

class Product extends Model
{
    protected $gurded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function presentPrice()
    {
        $money_format = new NumberFormatter('en_US', NumberFormatter::CURRENCY);

        return $money_format->formatCurrency($this->price / 100, 'USD');
    }

    public function scopeMightAlsoLike($query)
    {
        return $query->inRandomOrder()->take(4);
    }
}
