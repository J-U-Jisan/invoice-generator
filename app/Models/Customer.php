<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    public $timestamps = true;

    protected $fillable = [
        'customerName', 'date','currency', 'customerAddress', 'customerPhone', 'deliveryTime', 'tax', 'discount', 'advancePayment',
    ];

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function product()
    {
        return $this->hasMany('App\Models\Product');
    }
}
