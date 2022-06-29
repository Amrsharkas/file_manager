<?php

namespace Emam\Filemanager\App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DirectoryCreated
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
    private $name;

    /**
     * @return mixed
     */

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct($name,$path,$disk)
    {
        $this->name=$name;
        $this->path=$path;
        $this->disk=$disk;
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

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}
