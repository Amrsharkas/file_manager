<?php

namespace ie\fm\App\Services\FilePermission;

interface IFilePermissionPartner
{

    public function getUserID() : ?int ;
    public function getUsedDisk() : ?string ;
    public function getPermissions($path) ;

}
