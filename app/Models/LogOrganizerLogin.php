<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LogOrganizerLogin
 */
class LogOrganizerLogin extends Model
{
    protected $table = 'log_organizer_login';

    protected $primaryKey = 'log_number';

	public $timestamps = false;

    protected $fillable = [
        'organizer_number',
        'datetime',
        'ip_address',
        'user_agent'
    ];

    protected $guarded = [];

        
}