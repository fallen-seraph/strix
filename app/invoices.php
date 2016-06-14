<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoices extends Model
{
    public function invoice_items(){
        return $this->hasMany('App\invoice_items');
    }
}
