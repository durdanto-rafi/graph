<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuestionnaireQueryLength
 */
class TblQuestionnaireQueryLength extends Model
{
    protected $table = 'tbl_questionnaire_query_length';

    protected $primaryKey = 'query_length_number';

	public $timestamps = false;

    protected $fillable = [
        'query_number',
        'min_label',
        'max_label',
        'min_limit',
        'max_limit',
        'step'
    ];

    protected $guarded = [];

        
}