<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ApiSpeechTranscript
 */
class ApiSpeechTranscript extends Model
{
    protected $table = 'api_speech_transcript';

    protected $primaryKey = 'transcript_number';

	public $timestamps = true;

    protected $fillable = [
        'student_content_number',
        'transcript',
        'confidence'
    ];

    protected $guarded = [];

        
}