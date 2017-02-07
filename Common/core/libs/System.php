<?php

class System
{
    public static $token = null;

    public static function doNoClientConnection($token)
    {
        self::$token = $token;
    }

    public static function getToken()
    {
        return self::$token;
    }

    public static function showException($exp)
    {
        header('Content-Type: application/json');
        echo json_encode(array('error' => $exp->getMessage()));
        exit;
    }
}