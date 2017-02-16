<?php 
class Widget
{
    private $_controllerInstance;
    
    public function __construct()
    {
        $this->_controllerInstance = new Controller();
    }
    
    public function __call($name, $params)
    {
        $controller = $this->_controllerInstance->getModule($name);
        $args = array();
        call_user_func_array(
            array($controller, $params[0]),
            $args
        ); 
    }
    
    public function show($controller, $method, $params = array())
    {
        $controller = $this->_controllerInstance->getModule($controller);
        call_user_func_array(
            array($controller, $method),
            $params
        );
    }
}
