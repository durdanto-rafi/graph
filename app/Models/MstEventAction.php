<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MstEventAction
 */
class MstEventAction extends Model
{
    protected $table = 'mst_event_action';

    protected $primaryKey = 'event_action_number';

	public $timestamps = false;

    protected $fillable = [
        'event'
    ];

    protected $guarded = [];

        
}