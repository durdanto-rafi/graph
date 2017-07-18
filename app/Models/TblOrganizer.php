<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblOrganizer
 */
class TblOrganizer extends Model
{
    protected $table = 'tbl_organizer';

    protected $primaryKey = 'organizer_number';

	public $timestamps = false;

    protected $fillable = [
        'name',
        'password',
        'access_code',
        'enable',
        'vertical index'
    ];

    protected $guarded = [];

        
}