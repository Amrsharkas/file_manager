<?php

namespace Ie\FileManager\App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Paste
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var mixed
     */
    private $operation;
    /**
     * @var mixed
     */
    private $oldPath;
    /**
     * @var mixed
     */
    private $newPath;
    /**
     * @var mixed
     */
    private $type;

    /**
     * @return mixed
     */


    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct($operation,$oldPath,$newPath,$type)
    {
        $this->operation=$operation;
        $this->oldPath=$oldPath;
        $this->newPath=$newPath;
        $this->type=$type;
      //  dd($operation,$oldPath,$newPath,$type);
    }

    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @return mixed
     */
    public function getOldPath()
    {
        return $this->oldPath;
    }

    /**
     * @return mixed
     */
    public function getNewPath()
    {
        return $this->newPath;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
}
