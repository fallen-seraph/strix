<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoice_items extends Model
{
    public function invoices(){
        return $this->belongsTo('App\invoices');
    }
}
