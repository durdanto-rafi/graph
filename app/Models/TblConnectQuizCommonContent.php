<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblConnectQuizCommonContent
 */
class TblConnectQuizCommonContent extends Model
{
    protected $table = 'tbl_connect_quiz_common_contents';

    public $timestamps = false;

    protected $fillable = [
        'quiz_number',
        'common_contents_number'
    ];

    protected $guarded = [];

        
}