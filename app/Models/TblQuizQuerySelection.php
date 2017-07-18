<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuizQuerySelection
 */
class TblQuizQuerySelection extends Model
{
    protected $table = 'tbl_quiz_query_selection';

    protected $primaryKey = 'selection_number';

	public $timestamps = false;

    protected $fillable = [
        'query_number',
        'text'
    ];

    protected $guarded = [];

        
}