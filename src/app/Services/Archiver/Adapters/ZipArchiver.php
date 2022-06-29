<?php

namespace ie\fm\App\Services\Archiver\Adapters;
use ie\fm\App\Services\Archiver\ArchiverInterface;
use ie\fm\App\Services\Storage\FileStructure;
use ie\fm\App\Services\Tmpfs\Adapters\Tmpfs;
use ie\fm\App\Services\Tmpfs\TmpfsInterface;
use League\Flysystem\Filesystem as Flysystem;

class ZipArchiver implements ArchiverInterface
{
    protected $archive;

    protected $storage;

    protected $tmpfs;

    protected $uniqid;

    protected $tmp_files = [];

    public function __construct(Tmpfs $tmpfs)
    {
        $this->tmpfs = $tmpfs;
    }

    public function init(array $config = [])
    {

    }

    public function createArchive($uniqid,FileStructure $storage)
    {
        $this->archive = new Flysystem(new ZipAdapter($this->tmpfs->getFileLocation($uniqid)));
        $this->storage = $storage;

    }

    public function addDirectoryFromStorage(string $path)
    {
        $content = $this->storage->getDirectoryStructure($path, true,true);
        $this->archive->createDir($path);

        foreach ($content as $item) {
            if ($item['type'] == 'dir') {
                $this->archive->createDir($item['path']);
            }
            if ($item['type'] == 'file') {
                $this->addFileFromStorage($item['path']);
            }
        }
    }

    public function addFileFromStorage(string $path)
    {
        $file_uniqid = uniqid();

        $file = $this->storage->read($path);
        $this->tmpfs->write($file_uniqid, $file);
        $this->archive->write($path, $this->tmpfs->getFileLocation($file_uniqid));

        $this->tmp_files[] = $file_uniqid;
    }

    public function uncompress(string $source, string $destination, FileStructure $storage)
    {
        $name = uniqid().'.zip';

        $remote_archive = $storage->readStream($source);
        $this->tmpfs->write($name, $remote_archive['stream']);

        $archive = new Flysystem(new ZipAdapter($this->tmpfs->getFileLocation($name)));

        $contents = $archive->listContents('/', true);

        foreach ($contents as $item) {
            $stream = null;
            if ($item['type'] == 'dir') {
                $storage->createDir($destination, $item['path']);
            }
            if ($item['type'] == 'file') {
                $stream = $archive->readStream($item['path']);
                $storage->store($destination.'/'.$item['dirname'], $item['basename'], $stream);
            }
            if (is_resource($stream)) {
                fclose($stream);
            }
        }

        $this->tmpfs->remove($name);
    }

    public function closeArchive()
    {
        $this->archive->getAdapter()->getArchive()->close();

        foreach ($this->tmp_files as $file) {
            $this->tmpfs->remove($file);
        }
    }

    public function storeArchive($destination, $name)
    {
        $this->closeArchive();

        $file = $this->tmpfs->readStream($this->uniqid);
        $this->storage->store($destination, $name, $file['stream']);
        if (is_resource($file['stream'])) {
            fclose($file['stream']);
        }

        $this->tmpfs->remove($this->uniqid);
    }
}
