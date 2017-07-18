<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MstQueryType
 */
class MstQueryType extends Model
{
    protected $table = 'mst_query_type';

    protected $primaryKey = 'query_type_number';

	public $timestamps = false;

    protected $fillable = [
        'type',
        'type_jp'
    ];

    protected $guarded = [];

        
}