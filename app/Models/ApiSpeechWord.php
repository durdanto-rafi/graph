<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ApiSpeechWord
 */
class ApiSpeechWord extends Model
{
    protected $table = 'api_speech_word';

    protected $primaryKey = 'word_number';

	public $timestamps = false;

    protected $fillable = [
        'student_content_number',
        'start_time',
        'end_time',
        'word_kanji',
        'word_katakana',
        'transcript_number'
    ];

    protected $guarded = [];

        
}