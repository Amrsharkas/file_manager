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
    /**
     * @var CacheSystem
     */
    protected $cache;

    protected $availablity;
    /**
     * @var mixed
     */
    private $cacheUsed;
    /**
     * @var CacheSystem
     */
    private $cacheTimeout;

    private $user;
    
    protected $file_permissions;

    public function __construct(CacheSystem $cache)
    {
        $this->config = config('service_configuration');
        $this->cacheUsed=$this->config['PermissionsCache'];
        if ($this->cacheUsed){
            $this->cache=$cache;
            $this->cacheTimeout= $this->config['PermissionsCacheTime'];
        }
    }

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

    public function getcacheUsed() : ?int
    {
        return $this->cacheUsed;
    }

    public function getcacheTimeout() : ?int
    {
        return $this->cacheTimeout;
    }

    public function setUser($user)
    {
         $this->user =$user;
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
             if (!$this->cacheUsed){
                 $result=$dataMapper->fetchPermissions([
                     'user_id'=>$user,
                     'disk'=>$disk,
                     $search_path=>$path
                 ]);
                 if(!$first){
                     return $result;
                 }
                 else{
                     return  reset($result);
                 }
             }
             else{
                 //$this->cache->flushAllInCacheServer();
                 $key=$user.'_'.$disk.'_'.$path.'_'.'permissions';
                 if ($this->cache->existInCacheServer($key)){
                     return  $this->cache->fetchFromCacheServer($key);
                 }
                 else{
                     $permissions=$dataMapper->fetchPermissions([
                         'user_id'=>$user,
                         'disk'=>$disk,
                         $search_path=>$path
                     ]);
                     $this->cache->storeToCacheServer($key,$permissions,$this->cacheTimeout);
                     if($first!=1){
                         return $permissions;
                     }
                     else{
                         return   $permissions->first();
                     }
                 }

             }
        }
        return null;
    }
}

