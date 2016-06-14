<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class account_information extends Model
{
    protected $fillable = ['email', 'account_type', 'service', 'first_name', 'last_name', 'company','phone', 'address_one', 'address_two', 'city', 'state', 'zip', 'country'];
    //protected $connection = 'strixdb';
    protected $table = 'account_information';

    public function billing_information(){
        return $this->hasMany('App\billing_information');
    }

    public function invoices(){
        return $this->hasMany('App\invoices');
    }

    // public function User(){
    //     return $this->hasMany('App\User');
    // }
}
