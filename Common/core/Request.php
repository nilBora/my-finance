<?php

class Request
{   
    public function post($key = false)
    {   
        if ($key && array_key_exists($key, $_POST)) {
            return $_POST[$key];
        }
        
        return $_POST;
    }
}
