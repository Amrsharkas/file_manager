<?php

namespace Emam\Filemanager\App\Services\Download;

class CommonBrodcast
{

    public function brodcastMessage($data){
        $options = array(
            'cluster' => 'eu',
        );
        $config = config('service_configuration');
        $pusher_setting=$config['pusher'];
        $pusher = new \Pusher\Pusher(
            $pusher_setting['PUSHER_APP_KEY'],
            $pusher_setting['PUSHER_APP_SECRET'],
            $pusher_setting['PUSHER_APP_ID'],
            $options
        );
        $pusher->trigger('my-channel-'.auth()->id(), 'Ie\\FileManager\\App\\Events\\DownloadingStatusEvent', $data,
        );
    }

    function folderSize($dir){
        $total_size = 0;
        $count = 0;
        $dir_array = scandir($dir);
        foreach($dir_array as $key=>$filename){
            if($filename!=".." && $filename!="."){
                if(is_dir($dir."/".$filename)){
                    $new_foldersize = $this->foldersize($dir."/".$filename);
                    $total_size = $total_size+ $new_foldersize;
                }else if(is_file($dir."/".$filename)){
                    $total_size = $total_size + filesize($dir."/".$filename);
                    $count++;
                }
            }
        }
        if ($total_size==0){
            $total_size=1;
        }
        return $total_size;
    }
}
