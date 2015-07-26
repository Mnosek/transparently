<?php

namespace Core;


/**
 * Class autoloader
 * @author Michał Nosek <mmnosek@gmail.com>
 */
final class Autoloader
{
    /**
     * Array, where the key is a namespace prefix and the value
     * is an array of the base directories for the classes in that namespace
     * @var array
     */
    private $prefixes = array();
    
    
    /**
     * Autoloader constructor
     */
    public function __construct()
    {
        $this->addNamespace('Core', ROOT_PATH . 'Core');
        $this->addModules();
    }


    /**
     * Register loader by SPL autoloader
     *
     * @return void
     */
    public function register()
    {
        spl_autoload_register(array($this, 'load'));
    }


    /**
     * Add module namespaces and directories
     */
    private function addModules()
    {
        $dir = new \DirectoryIterator(MODULE_PATH);

        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                $this->addNamespace($fileinfo->getFilename(), 
                                    MODULE_PATH . $fileinfo->getFilename() . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR
                );
            }
        }
    }


    /**
     * Add a namespace and the base directory
     * @param string $prefix  namespace prefix
     * @param string $base_dir path to directory
     */
    public function addNamespace($prefix, $base_dir)
    {
        $prefix   = trim($prefix, '\\') . '\\';
        $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';

        if (isset($this->prefixes[$prefix]) === false) {
            $this->prefixes[$prefix] = array();
        }

        array_push($this->prefixes[$prefix], $base_dir);
    }


    /**
     * Loads the class by given name
     *
     * @param string $class class name
     * @return mixed File name on success, or boolean false on failure
     */
    public function load($name)
    {
        $prefix = $name;

        while (false !== $pos = strrpos($prefix, '\\')) {

            $prefix = substr($name, 0, $pos + 1);

            $relative_class = substr($name, $pos + 1);

            $mapped_file = $this->loadMappedFile($prefix, $relative_class);
            if ($mapped_file) {
                return $mapped_file;
            }

            $prefix = rtrim($prefix, '\\');   
     
        }

        //file not found
        return false;
    }


     /**
     * Load the mapped file for a namespace prefix and relative class.
     * 
     * @param string $prefix
     * @param string $relativeClass
     * @return mixed Boolean false if no mapped file loaded, or the
     * name of the mapped file that was loaded.
     */
    protected function loadMappedFile($prefix, $relativeClass)
    {
        if (isset($this->prefixes[$prefix]) === false) {
            return false;
        }

        foreach ($this->prefixes[$prefix] as $base_dir) {
            $filePath = $base_dir
                      . str_replace('\\', '/', $relativeClass)
                      . '.php';

            if ($this->requireFile($filePath)) {
                return $filePath;
            }
        }

        return false;
    }


    /**
     * If a file exists, require it from the file system.
     * 
     * @param string $file
     * @return bool
     */
    protected function requireFile($filePath)
    {
        if (file_exists($filePath)) {
            require $filePath;
            return true;
        }
        return false;
    }

}