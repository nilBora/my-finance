<?php
/* Extends Core API */
class Api extends Display
{
    /**
     * @Response type Response::TYPE_API
     */
    public function onApiRequest(Response &$response)
    {
       $uri = $_SERVER['REQUEST_URI'];
       $chunks = array_filter(explode('/', $uri));
       
       $moduleName = ucfirst($chunks[2]);
       $module = $this->controller->getModule($moduleName);
       
    }
}
