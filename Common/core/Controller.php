<?php

class Controller extends Dispatcher
{
    private $_core = null;
    private $_properties = array();
    private static $_modules = array();
    
    public function __construct()
    {
        parent::__construct();
        $this->_core = Core::getInstance();
    }

    public function getCurrentUserID()
    {
        return $this->_core->getUserID();
    }

    public function redirect($url)
    {
        //FIXME
        $href = 'http://' . $_SERVER['SERVER_NAME'];
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $href . $url);
        exit;
    }

    public function setSession($key, $value)
    {
        $this->_core->_setSession($key, $value);
    }

    public function doClearSession()
    {
        $this->_core->doClearSession();

        return true;
    }
    
    public static function getModule($module = 'User')
    {
        if (array_key_exists($module, static::$_modules)) {
            return static::$_modules[$module];
        }
       
        if (!class_exists($module)) {
            throw new Exception(sprintf("%s class Not found"), $module);
        }
        
        $pathModule = MODULES_DIR.$module.'/';
        
        $instance = new $module($pathModule);

        $moduleObject = $module.'Object';
        if (file_exists($pathModule.$moduleObject.'.php')) {
            $instance->object = new $moduleObject();
        }
        static::$_modules[$module] = $instance;
        
        return $instance;
    }
    
    public function includeStatic($name)
    {
        $this->setProperty($name, 'path');
    }
    
    public function setProperty($name, $path)
    {
        $this->_properties[$name] = $path;
    }
    
    public function getProperties()
    {
        return $this->_properties;
    }
}