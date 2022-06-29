<?php

namespace Ie\FileManager\App\Services\FilePermission;

use App\PmModels\FileManager;
use App\PmModels\Project;
use Ie\FileManager\App\Services\Cache\Adapters\CacheSystem;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Collection;

class FilePermissionChild extends FilePermissionPartner
{



    public function getPermissions($path)
    {
        // overwrite parent class
    }
}

