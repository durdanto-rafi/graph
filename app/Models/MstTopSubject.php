<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MstTopSubject
 */
class MstTopSubject extends Model
{
    protected $table = 'mst_top_subject';

    protected $primaryKey = 'top_subject_number';

	public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    protected $guarded = [];

        
}