<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MstUserLevel
 */
class MstUserLevel extends Model
{
    protected $table = 'mst_user_level';

    protected $primaryKey = 'user_level_number';

	public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    protected $guarded = [];

        
}