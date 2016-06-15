<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $connection = 'nagidb';
    protected $table = 'nagios_contact';
    protected $fillable = ['account_id', 'contact_name', 'alias', 'contact_groups', 'email', 'phone', misc', 'receive'];
}
