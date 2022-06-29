<?php

namespace Ie\FileManager\App\Services\Archiver\Adapters;

use League\Flysystem\Config as Flyconfig;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;

class ZipAdapter extends ZipArchiveAdapter
{
    public function write($path, $contents, Flyconfig $config)
    {
        $location = $this->applyPathPrefix($path);

        // using addFile instead of addFromString
        // is more memory efficient
        $this->archive->addFile($contents, $location);

        return compact('path', 'contents');
    }
}
