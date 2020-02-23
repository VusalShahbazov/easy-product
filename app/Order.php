<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const PerPage = 15;

    protected $fillable = ['name' , 'phone' , 'email' , 'address' , 'product_id' , 'user_id'];

    public function product(){
        return $this->belongsTo('App/Product');
    }
}
