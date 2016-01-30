<?php namespace App\Repositories;

use Anchu\Ftp\Facades\Ftp;
use GrahamCampbell\Flysystem\FlysystemManager;

class DirectoryRepository
{
    /**
     * @var FlysystemManager
     */
    private $flysystem;

    function __construct(FlysystemManager $flysystem)
    {
        $this->flysystem = $flysystem;
    }

    /**
     * Returns contents of a directory
     *
     * @param      $dirname
     *
     * @param bool $recursive
     *
     * @return array
     */
    function get($dirname, $recursive = false)
    {
        $contents = $this->flysystem->listContents($dirname, $recursive);
        usort($contents, function ($a, $b) {
            // Sort by type
            $c = strcmp($a['type'], $b['type']);
            if($c !== 0) return $c;

            // Sort by name
            return strcmp($a['filename'], $b['filename']);
        });
        return $contents;
    }

    /**
     * Creates a directory
     *
     * @param $dirname
     *
     * @return array
     */
    function create($dirname)
    {
        return $this->flysystem->createDir($dirname);
    }

    /**
     * Moves a directory
     *
     * @param $from
     * @param $to
     *
     * @return array
     */
    function move($from, $to)
    {
        return $this->flysystem->rename($from, $to);
    }

    /**
     * Deletes a directory
     *
     * @param $dirname
     *
     * @return bool
     */
    function delete($dirname)
    {
        return $this->flysystem->deleteDir($dirname);
    }
}