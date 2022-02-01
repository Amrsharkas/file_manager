<?php

namespace Ie\FileManager\Http\Controllers;

use App\Services\Storage\FileStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Mime\MimeTypes;

class ViewController extends Controller
{
    private $fileSystem;
    private $streamedResponse;
    private $separator = '/';

    public function __construct(FileStructure $fileSystem)
    {
        $this->fileSystem = $fileSystem;

    }

    public function previewFileAsText(Request $request)
    {
        $path = $request->input('path');
        $fileMetaData = $this->fileSystem->readFileMetaData($path);
        return json_encode(['path'=>$path,'contents' => $fileMetaData['contents']]);

    }

    public function previewFileAsMedia(Request $request): string
    {
//        return true;
//        dd($request->all());
//        dd("ss");
        $path = $request->input('path');
        return $this->fileSystem->getUrlLink($path);
    }
}
