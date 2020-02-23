<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title' , 'description' , 'category_id' , 'count'];
    const  ACTIVE = 1;
    const PerPage = 15;
    public function category(){
        return $this->belongsTo('App/Category');
    }
}
