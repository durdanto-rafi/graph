<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MstContentsCategory
 */
class MstContentsCategory extends Model
{
    protected $table = 'mst_contents_category';

    protected $primaryKey = 'contents_category_number';

	public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    protected $guarded = [];

        
}