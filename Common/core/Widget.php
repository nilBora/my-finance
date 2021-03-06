<?php 
class Widget
{    
    public function __call($name, $params)
    {
        $controller = Controller::getModule($name);
        $args = array();
        call_user_func_array(
            array($controller, $params[0]),
            $args
        ); 
    }
    
    public function show($controller, $method, $params = array())
    {
        $controller = Controller::getModule($controller);
        call_user_func_array(
            array($controller, $method),
            $params
        );
    }
}
