<?php

abstract class AbstractController extends Dispatcher
{
    protected $controller;
    protected $bundle;

    public function __construct()
    {
        parent::__construct();
        $core = &Core::getInstance();
        $this->controller = $core->getControllers();
        $this->bundle = $core->getBundles();
    }
}