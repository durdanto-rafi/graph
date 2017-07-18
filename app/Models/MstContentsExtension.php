<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MstContentsExtension
 */
class MstContentsExtension extends Model
{
    protected $table = 'mst_contents_extension';

    protected $primaryKey = 'contents_extension_number';

	public $timestamps = false;

    protected $fillable = [
        'extension'
    ];

    protected $guarded = [];

        
}