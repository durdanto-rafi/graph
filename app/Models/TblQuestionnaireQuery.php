<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuestionnaireQuery
 */
class TblQuestionnaireQuery extends Model
{
    protected $table = 'tbl_questionnaire_query';

    protected $primaryKey = 'query_number';

	public $timestamps = false;

    protected $fillable = [
        'questionnaire_number',
        'query',
        'query_type',
        'flg_query_must',
        'vertical_index',
        'enable'
    ];

    protected $guarded = [];

        
}