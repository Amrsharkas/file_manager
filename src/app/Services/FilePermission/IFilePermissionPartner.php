<?php

namespace Ie\FileManager\App\Services\FilePermission;

interface IFilePermissionPartner
{

    public function getUserID() : ?int ;
    public function getUsedDisk() : ?string ;
    public function getPermissions($path) ;

}
