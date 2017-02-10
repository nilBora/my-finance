<?php
//try {
    $mem = memory_get_usage();
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
echo '<pre style="color:red">'.(memory_get_usage() - $mem)."</pre>";