<?php

class Display extends AbstractModule
{
    private $_path = null;
    private $_layout = 'main.phtml';
    protected $fragment = false;
    protected $widget;

    public function __construct($path)
    {
        parent::__construct();
        $this->_path = $path;
    }
    
    public function display($content, $layout = 'main.phtml')
    {
        if ($this->fragment) {
            echo $content;
            
            return true;
        }
        $this->widget = new Widget();
        
        $vars['content'] = $content;
        $vars['infoPage'] = $this->controller->getProperties();
        
        $content = $this->fetch($layout, $vars);
        
        echo $content;
        
        return true;
    }
    
    public function getClassAnnotations($class, $method)
    {
        //use $this->getClassAnnotations($this, 'fetchMain');
        //$r = new ReflectionMethod($class, $method);       
        $r = new ReflectionClass($class);
        $doc = $r->getDocComment();
        preg_match_all('#@(.*?)\n#s', $doc, $annotations);
        return $annotations[1];
    }

    public function fetch($template, $vars = array(), $path = false)
    {
        if (!$template) {
            throw new Exception('Template not found');
        }
        
        if ($vars) {
            extract($vars);
        }

        $moduleTemplateDir = $this->_getModuleTemplateDir();
        
        if (file_exists($moduleTemplateDir . $template)) {
            $templatePath = $moduleTemplateDir . $template;
        } else {
            $templatePath = THEME_DIR . $template;
        }
       
        ob_start();

        include $templatePath;

        $content = ob_get_clean();

        return $content;
    }

    private function _getModuleTemplateDir()
    {
        return $this->_path . 'templates/';
    }
}