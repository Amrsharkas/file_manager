<?php

namespace Emam\Filemanager\App\Services\Download;

class StrategyDownloadContext
{
    private  $stratagy;
    private $uniqid;
    public function setStrategy($stratagy){
        $this->stratagy=$stratagy;
    }

    public function createUUid(){
        $filePermissions=app()->make(config('service_configuration')['filePermissions']);
        $custom_download_name=$filePermissions->addCustomNameToDownload();
        if ($custom_download_name!=""){
            $this->uniqid=$filePermissions->addCustomNameToDownload().'_'.uniqid();
        }
        else{
            $this->uniqid= uniqid();
        }
    }


    public function getUUid(){
        return $this->uniqid;
    }

    public function download($current,$paths,$archiver,$fileSystem){
        $this->stratagy->download($current,$paths,$archiver,$fileSystem);
    }

}
