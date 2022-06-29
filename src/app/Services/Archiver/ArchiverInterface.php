<?php

/*
 * This file is part of the FileGator package.
 *
 * (c) Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Ie\FileManager\App\Services\Archiver;



use Ie\FileManager\App\Services\Storage\FileStructure;

interface ArchiverInterface
{
    public function createArchive($uniqid,FileStructure $storage);

    public function uncompress(string $source, string $destination, FileStructure $storage);

    public function addDirectoryFromStorage(string $path);

    public function addFileFromStorage(string $path);

    public function closeArchive();

    public function storeArchive($destination, $name);
}
