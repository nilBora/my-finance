<?php

abstract class AbstractBundleController extends Dispatcher
{
    protected $controller;

    public function __construct()
    {
        parent::__construct();
        $this->controller = new Controller();
    }
}