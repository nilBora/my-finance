<?php

abstract class AbstractModule extends Dispatcher
{
    protected $controller;
    protected $request;

    public function __construct()
    {
        parent::__construct();
        
        $this->controller = Controller::getInstance();
        $this->request = new Request();
    }
    
    public function onBind()
    {
    }
}