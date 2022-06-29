<?php


namespace Emam\Filemanager\App\Services\FilePermission;


class StorageManager
{
    private  $table = 'file_user_permission';

    public function  find(array $data)
    {
        return \DB::table($this->table)
            ->where($data)
            ->get(['disk', 'path', 'access','type','has_all']);
    }

    public function  insert(array $data)
    {
        return \DB::table($this->table)
            ->insert($data);
    }


}
