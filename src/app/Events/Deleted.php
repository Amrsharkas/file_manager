<?php

namespace Emam\Filemanager\App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var mixed
     */
    private $disk;
    /**
     * @var mixed
     */
    private $paths;

    /**
     * @return mixed
     */
    /**
     * @var mixed
     */

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct($deleted_paths,$disk)
    {
        $this->paths=$deleted_paths;
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
    public function getPaths()
    {
        return $this->paths;
    }
}
