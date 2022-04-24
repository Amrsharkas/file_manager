<?php


namespace Ie\FileManager\App\Services\FilePermission;


class FilePermissionPartnerMapper
{
    private  $table = 'file_user_permission';

    public function __construct()
    {
    }

    public function  fetchPermissions(array $data)
    {
        return \DB::table($this->table)
            ->where($data)
            ->get(['disk', 'path', 'access','type','has_all']);
    }

    public function  savePermissions(array $data)
    {
        return \DB::table($this->table)
            ->insert($data);
    }
}
