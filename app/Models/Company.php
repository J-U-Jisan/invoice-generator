<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected $table = 'companies';
    public $timestamps = true;

    protected $fillable = [
        'companyName', 'companyLogo','comapnyAddress', 'companyEmail', 'companyPhone',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function customer()
    {
        return $this->hasMany('App\Models\Customer');
    }
}
