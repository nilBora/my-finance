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
    
    public function display($content, $layout = false)
    {
        //$a = $this->getClassAnnotations($this, 'fetchMain');
        //var_dump($a);
        if ($this->fragment) {
            echo $content;
            
            return true;
        }
        $this->widget = new Widget();
        
        $vars['content'] = $content;
        $vars['infoPage'] = $this->controller->getProperties();
        
        if (!$layout) {
            $layout = $this->_layout;    
        }
        $content = $this->fetch($layout, $vars);
        
        echo $content;
        
        return true;
    }
    
    public function getClassAnnotations($class, $method)
    {
        //$r = new ReflectionMethod($class, $method);       
        $r = new ReflectionClass($class);
        $doc = $r->getDocComment();
        preg_match_all('#@(.*?)\n#s', $doc, $annotations);
        return $annotations[1];
    }
    
    /**
     * @deprecated
     */
    public function fetchMain($template = false, $vars = array())
    {
        $vars['content'] = $this->fetch($template, $vars);
        $vars['infoPage'] = $this->controller->getProperties();
        $content = $this->fetch($this->_layout, $vars);

        return $content;
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
    
    public function setLayout($layout)
    {
        $this->_layout = $layout;
    }
}