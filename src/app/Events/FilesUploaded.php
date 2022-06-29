<?php

namespace ie\fm\App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FilesUploaded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var mixed
     */
    private $disk;
    /**
     * @var mixed
     */
    private $path;
    /**
     * @var mixed
     */
    private $files;

    public function __construct($path,$disk)
    {
        $this->disk=$disk;
        $this->path=$path;
    }

    /**
     * @return mixed
     */
    public function getDisk()
    {
        return $this->disk;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }
}
