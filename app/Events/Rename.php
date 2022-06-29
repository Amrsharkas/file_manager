<?php

namespace ie\fm\App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Rename
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var mixed
     */
    private $newName;
    /**
     * @var mixed
     */
    private $oldName;
    /**
     * @var mixed
     */
    private $disk;
    /**
     * @var mixed
     */
    private $type;
    private $path;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct($oldName,$newName,$path,$type,$disk)
    {
        $this->newName=$newName;
        $this->oldName=$oldName;
        $this->type=$type;
        $this->path=$path;
        $this->disk=$disk;
    }

    /**
     * @return mixed
     */
    public function getNewName()
    {
        return $this->newName;
    }

    /**
     * @return mixed
     */
    public function getOldName()
    {
        return $this->oldName;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }
}
