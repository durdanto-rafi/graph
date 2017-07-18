<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MstBoolean
 */
class MstBoolean extends Model
{
    protected $table = 'mst_boolean';

    protected $primaryKey = 'boolean_number';

	public $timestamps = false;

    protected $fillable = [
        'boolean'
    ];

    protected $guarded = [];

        
}