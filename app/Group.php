<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $connection = 'nagidb';
    protected $table = 'nagios_contact_group';
    protected $fillable = ['account_id', 'group_name', 'alias', 'members'];
}
