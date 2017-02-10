<?php

class Display extends AbstractModule
{
    private $_path = null;
    protected $layout = 'main.phtml';

    public function __construct($path)
    {
        parent::__construct();
        $this->_path = $path;
    }

    public function fetchMain($template = false, $vars = array())
    {
        $vars['content'] = $this->fetch($template, $vars);

        $content = $this->fetch($this->layout, $vars);

        return $content;
    }

    public function fetch($template = 'index.phtml', $vars = array())
    {
        if ($vars) {
            extract($vars);
        }

        $bundleTemplateDir = $this->_getBundleTemplateDir();
        
        if (file_exists($bundleTemplateDir . $template)) {
            $templatePath = $bundleTemplateDir . $template;
        } else {
            $templatePath = THEME_DIR . $template;
        }
       
        ob_start();

        include $templatePath;

        $content = ob_get_clean();

        return $content;
    }

    private function _getBundleTemplateDir()
    {
        return $this->_path . 'templates/';
    }
    
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}