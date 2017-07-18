<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LogAdminLogin
 */
class LogAdminLogin extends Model
{
    protected $table = 'log_admin_login';

    protected $primaryKey = 'log_number';

	public $timestamps = false;

    protected $fillable = [
        'admin_number',
        'datetime',
        'ip_address',
        'user_agent'
    ];

    protected $guarded = [];

        
}