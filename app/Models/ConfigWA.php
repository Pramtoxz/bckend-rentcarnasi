<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigWA extends Model
{
    protected $table= 'config_wa';
    protected $fillable = ['wa_gateway_url','wa_gateway_secret','wa_session_name','wa_group_id'];
}
