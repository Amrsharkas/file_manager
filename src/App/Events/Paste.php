<?php

namespace Emam\Filemanager\App\Events;

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

    private $disk;

    /**
     * @return mixed
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

    public function __construct($operation,$oldPath,$newPath,$name,$type,$disk)
    {
        $this->operation=$operation;
        $this->oldPath=$oldPath;
        $this->newPath=$newPath;
        $this->type=$type;
        $this->disk=$disk;
        $this->name=$name;
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

    public function getDisk()
    {
        return $this->disk;
    }

    public function getName()
    {
        return $this->name;
    }
}
