<?php

namespace Chamber\Theme;

/**
 * Directory and file finder.
 * 
 * @package    Chamber Theme
 * @author     Sean Bellows
 * @copyright  Copyright (c) 2016, Sean Bellows
 * @link       https://github.com/sebellows/chamber
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 */
class Finder
{

    /**
     * List of given/registered paths.
     *
     * @var array
     */
    protected $paths = [];

    /**
     * List of found files.
     * $key is the file name or relative path.
     * $value is the file full path.
     *
     * @var array
     */
    protected $files = [];

    /**
     * Allowed file extensions.
     *
     * @var array
     */
    protected $extensions = [];

    /**
     * Creates a new Finder.
     *
     * @return Finder A new Finder instance
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Register a path.
     *
     * @param string $key  The file URL if defined or numeric index.
     * @param string $path
     *
     * @return $this
     */
    protected function addPath($key, $path)
    {
        if (!in_array($path, $this->paths)) {
            if (is_numeric($key)) {
                $this->paths[] = $path;
            } else {
                $this->paths[$key] = $path;
            }
        }

        return $this;
    }

    /**
     * Register multiple file paths.
     * 
     * @param array $paths
     *
     * @return $this
     */
    public function addPaths(array $paths)
    {
        foreach ($paths as $index => $path) {
            $this->addPath($index, $path);
        }

        return $this;
    }

    /**
     * Return a list of registered paths.
     * 
     * @return array
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * Return a list of found files.
     *
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Returns the file path.
     *
     * @param string $name The file name or relative path.
     *
     * @return string
     *
     * @throws FinderException
     */
    public function find($name)
    {
        if (isset($this->files[$name])) {
            return $this->files[$name];
        }

        return $this->files[$name] = $this->findInPaths($name, $this->paths);
    }

    /**
     * Look after a file in registered paths.
     *
     * @param string $name  The file name or relative path.
     * @param array  $paths Registered paths.
     *
     * @throws FinderException
     *
     * @return array
     */
    protected function findInPaths($name, array $paths)
    {
        foreach ($paths as $path) {
            foreach ($this->getPossibleFiles($name) as $file) {
                if (file_exists($filePath = $path.$file)) {
                    return $filePath;
                }
            }
        }

        throw new \Exception('File or entity "'.$name.'" not found.');
    }

    /**
     * Returns a list of possible file names.
     *
     * @param string $name The file name or relative path.
     *
     * @return array
     */
    protected function getPossibleFiles($name)
    {
        return array_map(function ($extension) use ($name) {
            return str_replace('.', DS, $name).'.'.$extension;
        }, $this->extensions);
    }

    /**
     * @return string path to vendor directory
     */
    public static function getVendorDirectory(  ) {
        return dirname( dirname( __DIR__ ) );
    }

    /**
     * @param string $package vendor/package
     *
     * @return string|bool path to package directory or false
     */
    public static function getPackagePath( $package ) {
        $path = self::get_vendor_path() . '/' . $package;
        return file_exists( $path ) ? $path : false;
    }
}