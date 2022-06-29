<?php

namespace Emam\Filemanager\App\Services\Download;

class StrategyDefault extends  CommonBrodcast
{

    public function download($current,$paths,$archiver,$fileSystem){
        $uniqid =   $archiver->createArchive($current,$fileSystem);
        foreach ($paths as $item) {
            $item=(object)$item;
            if ($item->type == 'dir') {
                $archiver->addDirectoryFromStorage($item->path);
            }
            if ($item->type == 'file') {
                $archiver->addFileFromStorage($item->path);
            }
        }
        $archiver->closeArchive();
        return  $uniqid;
    }



    public function compress(){

    }

}
