<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class billing_information extends Model
{
    public function account_information(){
        return $this->belongsTo('App\account_information');
    }
}
