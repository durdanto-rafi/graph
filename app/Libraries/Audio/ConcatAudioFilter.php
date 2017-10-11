<?php

namespace App\Libraries\Audio;

use FFMpeg\Media\Audio;
use FFMpeg\Format\AudioInterface;
use FFMpeg\Filters\Audio\AudioFilterInterface;

class ConcatAudioFilter implements AudioFilterInterface
{
    private $files;
    private $priority;
    public function __construct(array $files = [], $priority = 0)
    {
        $this->files = $files;
        $this->priority = $priority;
    }
    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return $this->priority;
    }
    public function addFile($file)
    {
        $this->files[] = $file;
        return $this;
    }
    public function addFiles(array $files)
    {
        foreach ($files as $file) {
            $this->addFile($file);
        }
        return $this;
    }
    public function deleteFile($fileToDelete)
    {
        $this->files = array_values(array_filter($this->files, function($file) use ($fileToDelete) {
            return $fileToDelete !== $file;
        }));
    }
    /**
     * {@inheritdoc}
     */
    public function apply(Audio $audio, AudioInterface $format)
    {
        $params = [];
        $count = count($this->files) + 1;
        foreach ($this->files as $i => $file) {
            $params[] = '-i';
            $params[] = $file;
        }
        $params[] = '-filter_complex';
        $params[] = 'concat=n='.$count.':v=0:a=1 [a]';
        $params[] = '-map';
        $params[] = '[a]';
        return $params;
    }
}