<?php

class Controller extends Dispatcher
{
    private $_core = null;

    public function __construct()
    {
        parent::__construct();
        $this->_core = Core::getInstance();
    }

    public function getController($controller = 'Main')
    {
        return new $controller($controller);
    }

    public function getUserID()
    {
        //OLD
        return $this->_core->getUserID();
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

    public function getBundleInstance($bundle = 'Main')
    {
        $path = MODULES_DIR.$bundle.'/'.$bundle.'.php';
        if (!file_exists($path)) {
            throw new Exception('Not found bundle');
        }
        $instance = new $bundle(MODULES_DIR.$bundle.'/');

        $pathObject = MODULES_DIR.$bundle.'/'.$bundle.'Object.php';
        if (file_exists($pathObject)) {
            $bundleObject = $bundle.'Object';
            $instance->object = new $bundleObject();
        }

        return $instance;
    }
}