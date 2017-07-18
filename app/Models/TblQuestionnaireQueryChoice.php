<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuestionnaireQueryChoice
 */
class TblQuestionnaireQueryChoice extends Model
{
    protected $table = 'tbl_questionnaire_query_choices';

    protected $primaryKey = 'choices_number';

	public $timestamps = false;

    protected $fillable = [
        'query_number',
        'text'
    ];

    protected $guarded = [];

        
}