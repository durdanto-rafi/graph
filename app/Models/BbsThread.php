<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BbsThread
 */
class BbsThread extends Model
{
    protected $table = 'bbs_thread';

    protected $primaryKey = 'thread_number';

	public $timestamps = false;

    protected $fillable = [
        'post_name',
        'title',
        'delete_key',
        'user_level',
        'user_number',
        'school_number',
        'agreement_flg',
        'student_opened_flg',
        'enable',
        'register_datetime'
    ];

    protected $guarded = [];

        
}