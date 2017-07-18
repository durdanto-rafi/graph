<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LogStudentLogin
 */
class LogStudentLogin extends Model
{
    protected $table = 'log_student_login';

    protected $primaryKey = 'log_number';

	public $timestamps = false;

    protected $fillable = [
        'student_number',
        'datetime',
        'ip_address',
        'user_agent'
    ];

    protected $guarded = [];

        
}