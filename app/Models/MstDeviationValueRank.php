<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MstDeviationValueRank
 */
class MstDeviationValueRank extends Model
{
    protected $table = 'mst_deviation_value_rank';

    protected $primaryKey = 'rank_number';

	public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    protected $guarded = [];

        
}