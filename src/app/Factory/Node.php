<?php

namespace Ie\FileManager\App\Factory;


class Node
{
    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return mixed
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return mixed
     */
    public function getNodes()
    {
        return $this->nodes;
    }
    private $text;
    private $href;
    private $type;
    private $extension;
    private $nodes;

    /**
     * @param mixed $filename
     */
    public function setFilename($filename): void
    {
        $this->text = $filename;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->href = $path;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @param mixed $extension
     */
    public function setExtension($extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @param mixed $children
     */
    public function setChildren($children): void
    {
        $this->nodes = $children;
    }

}
