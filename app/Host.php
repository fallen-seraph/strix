<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    protected $connection = 'nagidb';
    protected $table = 'nagios_host';
    protected $fillable = ['account_id', 'host_name', 'alias', 'address', 'contacts', 'contact_groups'];
}
