<?php

class Response extends Dispatcher
{
    const TYPE_NORMAL = 'normal';
    const TYPE_JSON = 'json';
    const TYPE_API = 'api';
    
    const ACTION_REDIRECT = 'redirect';
    
    private $_layout = 'main.phtml';
    private $_type;
    
    public $content = '';
    
    public function __construct($type = self::TYPE_NORMAL)
    {
        $this->setType($type);
    }
    
    public function send($module = false)
    {
        if ($this->_isTypeNormal()) {
            $module->display($this->content, $this->_layout);
            
            return true;
        }
        
        if ($this->_isTypeJson()) {
            echo json_encode(array('content' => $this->content));
            exit;
        }
        
        if ($this->_type == static::TYPE_API) {
            
             echo json_encode(array('content' => $this->content, 'vars' => $this));
             exit;
        }
        
    }
    
    private function _isTypeNormal()
    {
        return $this->_type == static::TYPE_NORMAL;
    }
    
    private function _isTypeJson()
    {
        return $this->_type == static::TYPE_JSON;
    }
    
    public function setLayout($layout)
    {
        $this->_layout = $layout;
    }
    
    public function setType($type)
    {
        $this->_type = $type;
    }
    
    public function setAction($action)
    {
        $this->_action = $action;
    }
}
