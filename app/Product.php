<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'cost', 'amount'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
