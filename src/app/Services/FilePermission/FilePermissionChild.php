<?php

namespace ie\fm\App\Services\FilePermission;

use App\PmModels\FileManager;
use App\PmModels\Project;
use ie\fm\App\Services\Cache\Adapters\CacheSystem;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Collection;

class FilePermissionChild extends FilePermissionPartner
{



    public function getPermissions($path)
    {
        // overwrite parent class
    }
}

