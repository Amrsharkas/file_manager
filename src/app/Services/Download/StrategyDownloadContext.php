<?php

namespace Ie\FileManager\App\Services\Download;

class StrategyDownloadContext
{
    private  $stratagy;
    private $uniqid;
    public function setStrategy($stratagy){
        $this->stratagy=$stratagy;
    }
    
    public function createUUid(){
        $this->uniqid=uniqid();
    }


    public function getUUid(){
        return $this->uniqid; 
    }
    
    public function download($current,$paths,$archiver,$fileSystem){
        $this->stratagy->download($current,$paths,$archiver,$fileSystem);
    }

}
