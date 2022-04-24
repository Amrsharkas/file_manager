<?php

namespace Ie\FileManager\Http\Controllers;


use Ie\FileManager\App\Services\Storage\FileStructure;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{

    private $fileSystem;

    public function __construct(FileStructure $fileSystem)
    {
        
        $middlewares=config('service_configuration.middlewares');
        if (count($middlewares)>0){
            $this->middleware($middlewares);
        }
        $this->fileSystem=$fileSystem;
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getDirectory(Request $request)
    {
        $root =$this->setRootPath($request);
        if ($root !='false'){
            $mainPath=$request->input('dir',$this->fileSystem->getRootPath());
            $cache=filter_var($request->input('cache',true), FILTER_VALIDATE_BOOLEAN);
            $breadcrumbs=$this->fileSystem->buildBreadcrumbStructure($mainPath);
            $contents = $this->fileSystem->getDirectoryStructure($mainPath,false,$cache);
            $directoriesPerTree = json_encode($this->fileSystem->filterDirectoryStructure($contents,'dir'));
            $disk=$this->fileSystem->getDisk();
            return $this->renderView(compact('contents','mainPath','breadcrumbs','directoriesPerTree','root','disk'),'fm.base','fm.contents');
        }
        return 'Insufficient permissions';
    }

    public function getTree(Request $request)
    {
        $mainPath=$request->input('dir',$this->fileSystem->getRootPath());
        $recursive=$request->input('recursive',true);
        $type=$request->input('type','dir');
        $tree=$this->fileSystem->getTreeStructure($mainPath,$recursive,$type);
        return  json_encode($tree);
    }

    public function getDirectoriesForTree(Request $request)
    {
        $mainPath=$request->input('dir','/');
        $tree=$this->fileSystem->getDirectories($mainPath);
        return  json_encode($tree);
    }

    private function setRootPath($request): string
    {
        $root=$request->input('rootPath',$this->fileSystem->getSeparator());
        $dir=$request->input('dir');
         if ($root && isset($dir)){
            $treeFamily=collect($this->fileSystem->getAllParents($dir,true))->pluck('path')->toArray();
            if (in_array($root,$treeFamily)) {
                return $root;
            }
        }
        return 'false';
    }


}
