<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuizQuery
 */
class TblQuizQuery extends Model
{
    protected $table = 'tbl_quiz_query';

    protected $primaryKey = 'quiz_query_number';

	public $timestamps = false;

    protected $fillable = [
        'quiz_number',
        'query',
        'explain',
        'query_type',
        'vertical_index',
        'enable',
        'image_flg',
        'score'
    ];

    protected $guarded = [];

        
}