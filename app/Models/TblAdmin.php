<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblAdmin
 */
class TblAdmin extends Model
{
    protected $table = 'tbl_admin';

    protected $primaryKey = 'admin_number';

	public $timestamps = false;

    protected $fillable = [
        'school_number',
        'name',
        'password',
        'access_code',
        'access_datetime',
        'enable',
        'vertical_index'
    ];

    protected $guarded = [];

        
}