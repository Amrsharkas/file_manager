<?php

namespace Ie\FileManager\App\Services\FilePermission;

use App\PmModels\FileManager;
use App\PmModels\Project;
use Ie\FileManager\App\Services\Cache\Adapters\CacheSystem;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Collection;

class FilePermissionPartner implements IFilePermissionPartner
{
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $config;

    protected $availablity;
    
    private $user;
    
    protected $file_permissions;
    

    public function getUserID() : ?int
    {
        return $this->user->id;
    }

    public function getAvailablity() : ?int
    {
        return $this->availablity;
    }

    public function setAvailablity($availablity)
    {
         $this->availablity=$availablity;
    }
    

    public function setUser($user)
    {
         $this->user =$user;
    }

    public function getUser()
    {
        return $this->user;
    }


    public function getUsedDisk() : ?string
    {
        return config('service_configuration.disk');
    }
    
    public function setFileManagerPermissions($file_permissions){
        $this->file_permissions=$file_permissions;
    }

    public function getFileManagerPermissions(){
       return $this->file_permissions;
    }


    public function getPermissions($path,$search_path='parent',$first=false)
    {
        $config = config('service_configuration');
         if ($this->getAvailablity()) {
             $this->setUser(Auth::user());
             $user=$this->getUserID();
             $disk=$this->getUsedDisk();
             // you can return array that want
             $dataMapper = new FilePermissionPartnerMapper();
             if ($path!=false){
                 $result=$dataMapper->fetchPermissions([
                     'user_id'=>$user,
                     'disk'=>$disk,
                     $search_path=>$path
                 ]);
             }
             else{
                 $result=$dataMapper->fetchPermissions([
                     'user_id'=>$user,
                     'disk'=>$disk,
                     'user_id'=>$this->getUser()->id
                 ]);
             }
             if(!$first){
                 return $result;
             }
             else{
                 return  reset($result);
             }
        }
        return null;
    }
}

