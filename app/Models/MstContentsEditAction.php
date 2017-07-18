<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MstContentsEditAction
 */
class MstContentsEditAction extends Model
{
    protected $table = 'mst_contents_edit_action';

    protected $primaryKey = 'contents_edit_action_number';

	public $timestamps = false;

    protected $fillable = [
        'action'
    ];

    protected $guarded = [];

        
}