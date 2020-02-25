<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const  ACTIVE = 1;
    const PerPage = 15;
    protected $fillable = ['title', 'description', 'category_id', 'count' , 'is_active'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
