<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MstSpeed
 */
class MstSpeed extends Model
{
    protected $table = 'mst_speed';

    protected $primaryKey = 'speed_number';

	public $timestamps = false;

    protected $fillable = [
        'speed'
    ];

    protected $guarded = [];

        
}