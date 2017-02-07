<?php

class SystemLog
{
    public static function getMessage($exp)
    {
        $fileName = self::_getFileLogName($exp);
        $ip = self::getIP();
        $content = date('d-m-Y H:s:i').' IP: '.$ip.' '.$exp->getMessage()."\n";
        $fileName = ROOT_DIR.'logs/'.$fileName.'.log';
        file_put_contents($fileName, $content, FILE_APPEND);

        return true;
    }

    private function _getFileLogName($exp)
    {
        return get_class($exp);
    }

    public static function getIP()
    {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        return $ip;
    }
}