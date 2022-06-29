<?php

namespace Emam\Filemanager\App\Factory;

class NodeFactory
{
    public function createNode($type,$path,$filename,$children,$extension): array
    {
        $node = [];
        $node['type']=($type);
        $node['data']=$path;
        $node['text']=($filename);
        $node['children']=($children);
        $node['extension']=($extension);;
        return  $node;
    }
}
