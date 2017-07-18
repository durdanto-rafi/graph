<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LogTeacherLogin
 */
class LogTeacherLogin extends Model
{
    protected $table = 'log_teacher_login';

    protected $primaryKey = 'log_number';

	public $timestamps = false;

    protected $fillable = [
        'teacher_number',
        'datetime',
        'ip_address',
        'user_agent'
    ];

    protected $guarded = [];

        
}