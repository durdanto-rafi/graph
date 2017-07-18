<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LogSchoolContentsEditAdmin
 */
class LogSchoolContentsEditAdmin extends Model
{
    protected $table = 'log_school_contents_edit_admin';

    protected $primaryKey = 'log_number';

	public $timestamps = false;

    protected $fillable = [
        'school_contents_number',
        'admin_number',
        'contents_edit_action_number',
        'datetime'
    ];

    protected $guarded = [];

        
}