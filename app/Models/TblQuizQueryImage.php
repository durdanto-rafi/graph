<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TblQuizQueryImage
 */
class TblQuizQueryImage extends Model
{
    protected $table = 'tbl_quiz_query_image';

    protected $primaryKey = 'quiz_query_number';

	public $timestamps = false;

    protected $fillable = [
        'file_name',
        'file_path'
    ];

    protected $guarded = [];

        
}