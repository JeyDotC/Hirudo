<?php

/**
 * «Copyright 2012 Jeysson José Guevara Mendivil(JeyDotC)» 
 * 
 * This file is part of Hirudo.
 * 
 * Hirudo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Hirudo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Lang;

use \LogicException as LogicException;
use \RecursiveDirectoryIterator as RecursiveDirectoryIterator;

class InvalidPathException extends LogicException {

    function __construct($path) {
        $this->message = "The given path '$path' is invalid, expected to have 
                this format: 'rootFolder::route::to::MyFile'";
    }

}

/**
 * <p>A PHP file loader. It's like an enhanced require_once. The improvements
 * consist on:</p>
 * 
 * <ul>
 *      <li>Having a sigle style for path strings using the '::' notation for directrory separators</li>
 *      <li>The use of the '*' notation to load all files in a path.</li>
 * </ul>
 * 
 * @see Loader::using()
 */
final class Loader {

    const DEFAULT_EXT = ".php";

    private static $ROOT = "";
    private static $DS = "";

    /**
     * Sets the root folder and the Directory separator for the loader.
     * 
     * @param string $ROOT The root folder, preferably an absolute path.
     * @param string $DS The directory separator.
     */
    public static function Config($ROOT, $DS) {
        self::$DS = $DS;
        self::$ROOT = $ROOT;
    }

    /**
     * <p>Loads a PHP file using a package syntax which consists of a path from 
     * the Loader's root where is used the <code>::</code> operator instead of
     * the directory separator and ommiting the file extension. 
     * e.g. <code>Loader::using("folder::inner::MyPhpFile")</code></p>
     * 
     * <p>The character <code>*</code> can be used to load all the files in a 
     * directory.</p>
     * 
     * @param string|array $file The path or paths to the files with the format 
     * specified above.
     * 
     * @param string $extension = ".php" An optional extension to be applied when 
     * a file  doesn't belong to the group of files found from the <code>*</code> 
     * operator.
     * 
     * @throws InvalidPathException If $string is not a string, is null or is empty.
     * @throws LogicException If $extension is not a string.
     */
    public static function using($file, $extension = Loader::DEFAULT_EXT) {
        $paths = array();
        if (is_array($file)) {
            $paths = self::arrayToPaths($file, $extension);
        } else {
            $paths = self::toPaths($file, $extension);
        }

        foreach ($paths as $path) {
            if (substr($path, -strlen($extension)) == $extension) {
                require_once $path;
            }
        }
    }

    /**
     * Traduces a list of strings with the {@link Loader::using()} format to the
     * resulting paths.
     * 
     * @param array $array An array of strings representing the paths.
     * @param string $extension An extension to be applied to the paths.
     * @return array An array of absolute paths.
     * 
     * @see Loader::using() For more details.
     * @see Loader::resolvePaths() For more details.
     * 
     * @throws InvalidPathException If $string is not a string, is null or is empty.
     * @throws LogicException If $extension is not a string.
     */
    public static function arrayToPaths(array $array,
            $extension = Loader::DEFAULT_EXT) {
        $paths = array();
        foreach ($array as $package) {
            $actualPaths = self::toPaths($package, $extension);
            $paths = array_merge($paths, $actualPaths);
        }

        return $paths;
    }

    /**
     * Traduces string with the {@link Loader::using()} format to the
     * resulting paths.
     * 
     * @param array $array A string representing the paths.
     * @param string $extension An extension to be applied to the paths.
     * @return array An array of absolute paths.
     * 
     * @see Loader::using() For more details.
     * 
     * @throws InvalidPathException If $string is not a string, is null or is empty.
     * @throws LogicException If $extension is not a string.
     */
    public static function toPaths($string, $extension = Loader::DEFAULT_EXT) {
        //Check if the path and extension are correct.
        self::validateArgs($string, $extension);

        $package = str_replace("::", self::$DS, $string);
        $path = self::$ROOT . self::$DS . $package;
        $paths = array();
        //Resolve paths for * wildcard.
        if (strrpos($path, "*") !== false) {
            $url = str_replace("*", "", $path);
            $directoryHelper = new DirectoryHelper(new RecursiveDirectoryIterator($url));
            $paths = $directoryHelper->listFiles();
        } else {
            $paths = array($path . $extension);
        }

        return $paths;
    }

    public static function toSinglePath($string,
            $extension = Loader::DEFAULT_EXT) {
        $paths = self::toPaths($string, $extension);
        $path = "";
        if (count($paths) > 0) {
            $path = $paths[0];
        }

        return $path;
    }

    private static function validateArgs($file, $extension) {
        //If file is null or empty, simply do nothing.
        if (!is_string($file) || $file == null || $file == "") {
            throw new InvalidPathException((string) $file);
        }
        if (!is_string($extension)) {
            throw new LogicException("The extension is expected to be a string");
        }
    }

}

/**
 * Alias for {@link Loader::using()} function.
 * 
 * @param string|array $file
 * @param string $extension 
 * 
 * @see Loader::using()
 * 
 * @throws InvalidPathException If $string is not a string, is null or is empty.
 * @throws LogicException If $extension is not a string.
 */
function _using($file, $extension = Loader::DEFAULT_EXT) {
    Loader::using($file, $extension);
}

/**
 * A class for directory listing.
 */
class DirectoryHelper {

    /**
     *
     * Creates a directory helper.
     * 
     * @param RecursiveDirectoryIterator $dir The root folder from which this 
     * directory helper will work.
     */
    function __construct(RecursiveDirectoryIterator &$dir) {
        $this->dir = $dir;
    }

    /**
     * The directory iterator.
     * 
     * @var RecursiveDirectoryIterator
     */
    private $dir;

    /**
     * Lists all files, ignoring the directories, for the actual DirectoryIterator
     * at the specified depth.
     * 
     * @param int $depth The depth for which this iterator will find the files.
     * 
     * @return array The list of absolute paths to the found files.
     */
    public function listFiles($depth = 1) {
        if ($depth < 0) {
            throw new LogicException("depth must be positive.");
        }
        $paths = $this->recursiveListFiles($this->dir, $depth);
        return $paths;
    }

    private function recursiveListFiles(RecursiveDirectoryIterator &$dir,
            $depth = 1) {

        $paths = array();

        while ($dir->valid()) {
            if (!$dir->isDot() && $dir->isDir() && $depth > 1) {
                $paths = array_merge($paths, $this->recursiveListFiles($dir->getChildren(), $depth - 1));
            } else if (!$dir->isDot() && $dir->isFile()) {
                $paths[] = $dir->getPathName();
            }
            $dir->next();
        }

        return $paths;
    }

}

?>
