<?php

class System
{
    public static function showException($exp)
    {
        header('Content-Type: application/json');
        echo json_encode(array('error' => $exp->getMessage()));
        exit;
    }
}