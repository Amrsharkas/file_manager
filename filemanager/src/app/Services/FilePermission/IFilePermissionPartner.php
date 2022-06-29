<?php

namespace Emam\Filemanager\App\Services\FilePermission;

interface IFilePermissionPartner
{

    public function getUserID() : ?int ;
    public function getUsedDisk() : ?string ;
    public function getPermissions($path) ;

}
