<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BbsThreadSubject
 */
class BbsThreadSubject extends Model
{
    protected $table = 'bbs_thread_subject';

    public $timestamps = false;

    protected $fillable = [
        'subject_number',
        'thread_number',
        'subject_category_number',
        'subject_group_number',
        'subject_section_number'
    ];

    protected $guarded = [];

        
}