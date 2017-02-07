<?php
if (!session_id()) {
	session_start();
}
define('ROOT_DIR', __DIR__.'/');
define('COMMON_DIR', ROOT_DIR.'Common/');
define('CORE_DIR', COMMON_DIR.'core/');
define('BUNDLE_DIR', COMMON_DIR.'bundle/');
define('TEMPLATE_DIR', ROOT_DIR.'templates/');
define('THEME_DIR', ROOT_DIR.'theme/');
define('CRONS_DIR', ROOT_DIR.'crons/');
define('CRON_SOCKET_TMP_DIR', CRONS_DIR.'socket_tmp/');


require_once "config.php";

require_once CORE_DIR.'Dispatcher.php';
require_once CORE_DIR.'Controller.php';
require_once CORE_DIR.'Route.php';
require_once CORE_DIR.'Object.php';
require_once CORE_DIR.'Core.php';
require_once CORE_DIR.'AbstractController.php';
require_once CORE_DIR.'Display.php';

require_once CORE_DIR.'ValuesObject.php';
require_once CORE_DIR . 'libs/Exception.php';
require_once CORE_DIR . 'libs/SystemLog.php';
require_once CORE_DIR . 'libs/System.php';


$db = new PDO(
    $GLOBALS['db'],
    $GLOBALS['user'],
    $GLOBALS['password']
);

$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$db->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$res = $db->query('SET NAMES utf8');

$core = Core::getInstance();
$core->db = Object::factory($db);


