<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MstVolume
 */
class MstVolume extends Model
{
    protected $table = 'mst_volume';

    protected $primaryKey = 'volume_number';

	public $timestamps = false;

    protected $fillable = [
        'volume'
    ];

    protected $guarded = [];

        
}