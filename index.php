<?php
$debug = true;

require_once __DIR__ . '/Common/core/libs/SystemLog.php';

if ($debug) {
    SystemLog::startRecord();    
}

//try {
   // include_once dirname(__FILE__).'/.env';
    include_once dirname(__FILE__).'/config.php';
    include_once dirname(__FILE__).'/common.php';

    $core = Core::getInstance();

    $core->start();
// } catch (NotFoundException $exp) {
    // header("HTTP/1.0 404 Not Found");
    // echo "404";
    // exit;
// } catch(SystemException $exp) {
    // SystemLog::getMessage($exp);
    // echo $exp->getMessage();
// } catch(DisplayException $exp) {
    // //echo $exp->getMessage();
    // System::showException($exp);
// } catch (Exception $exp) {
    // echo $exp->getMessage();
// }
if ($debug) {
    SystemLog::showInfo();
}