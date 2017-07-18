<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MstEventReason
 */
class MstEventReason extends Model
{
    protected $table = 'mst_event_reason';

    protected $primaryKey = 'event_reason_number';

	public $timestamps = false;

    protected $fillable = [
        'reason'
    ];

    protected $guarded = [];

        
}