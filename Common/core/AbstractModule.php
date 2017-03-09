<?php

abstract class AbstractModule extends Dispatcher
{
    protected $controller;
    protected $request;

    public function __construct()
    {
        parent::__construct();
        $this->controller = new Controller();
        $this->request = new Request();
    }
}