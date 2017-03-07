<?php

class Response extends Dispatcher
{
    const TYPE_NORMAL = 'normal';
    const TYPE_AJAX = 'ajax';
    
    private $_type;
    
    public function __construct($type = self::TYPE_NORMAL)
    {
        $this->_type = $type;
    }
    
    public function send($module = false)
    {
        $module->display($this->content);
    }
}
