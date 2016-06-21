<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostService extends Model
{
    protected $connection = 'nagidb';
    protected $table = 'nagios_host_services';
    protected $fillable = ['host_id', 'account_id', 'service_id', 'host_name', 'service_description', 'check_command', 'contacts', 'contact_groups'];
}
