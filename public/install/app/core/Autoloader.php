<?php

class Autoloader
{
    protected $base_dirs = array();

    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    public function addBaseDir($base_dir, $prepend = false)
    {
        $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';

        if (!in_array($base_dir, $this->base_dirs)) {

            if ($prepend) {
                array_unshift($this->base_dirs, $base_dir);
            } else {
                array_push($this->base_dirs, $base_dir);
            }
        }

    }

    public function loadClass($class)
    {
        $class_name = ltrim($class, '\\');
        $relative_class  = '';
        $namespace = '';

        if ($last_ns_pos = strrpos($class_name, '\\')) {
            $namespace = substr($class_name, 0, $last_ns_pos);
            $class_name = substr($class_name, $last_ns_pos + 1);
            $relative_class  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }

        $relative_class .= $class_name . '.php';


        foreach ($this->base_dirs as $base_dir) {
            $mapped_file = $this->loadMappedFile($base_dir, $relative_class);
            if ($mapped_file) {
                return $mapped_file;
            }            
        }

        return false;
    }

    protected function loadMappedFile($base_dir, $relative_class)
    {

        $file = $base_dir
              . DIRECTORY_SEPARATOR
              . $relative_class; 

        if ($this->requireFile($file)) {
            return $file;
        }

        return false;
    }

    protected function requireFile($file)
    {
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
        return false;
    }
}