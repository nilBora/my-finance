<?php

abstract class AbstractController extends Dispatcher
{
    protected $controller;

    public function __construct()
    {
        parent::__construct();
        $this->controller = new Controller();
    }
}