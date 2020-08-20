<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'quantity', 'external_id'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
