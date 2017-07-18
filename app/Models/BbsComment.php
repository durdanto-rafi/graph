<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BbsComment
 */
class BbsComment extends Model
{
    protected $table = 'bbs_comment';

    protected $primaryKey = 'comment_number';

	public $timestamps = false;

    protected $fillable = [
        'thread_number',
        'post_name',
        'text',
        'delete_key',
        'user_level',
        'user_number',
        'agreement_flg',
        'student_opened_flg',
        'enable',
        'register_datetime'
    ];

    protected $guarded = [];

        
}