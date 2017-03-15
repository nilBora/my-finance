<?php
if (!session_id()) {
	session_start();
}
define('ROOT_DIR', __DIR__.'/');
define('COMMON_DIR', ROOT_DIR.'Common/');
define('CORE_DIR', COMMON_DIR.'core/');
define('MODULES_DIR', COMMON_DIR.'modules/');
define('TEMPLATE_DIR', ROOT_DIR.'templates/');
define('THEME_DIR', ROOT_DIR.'theme/');
define('HELPERS_DIR', CORE_DIR.'helpers/');

require_once "config.php";
require_once HELPERS_DIR.'HelpersFunctions.php';
require_once CORE_DIR.'Dispatcher.php';
require_once CORE_DIR.'Controller.php';
require_once HELPERS_DIR.'Route.php';
require_once CORE_DIR.'/db/Object.php';
require_once CORE_DIR.'Core.php';
require_once CORE_DIR.'AbstractModule.php';
require_once CORE_DIR.'Display.php';
require_once CORE_DIR.'Container.php';
require_once CORE_DIR.'Widget.php';
require_once CORE_DIR.'Response.php';
require_once HELPERS_DIR.'Request.php';

require_once HELPERS_DIR.'ValuesObject.php';
require_once CORE_DIR . 'libs/Exception.php';
require_once CORE_DIR . 'libs/SystemLog.php';
require_once CORE_DIR . 'libs/System.php';


$db = new PDO(
    $GLOBALS['dsn']['db'],
    $GLOBALS['dsn']['user'],
    $GLOBALS['dsn']['password']
);

$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$db->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->query('SET NAMES utf8');

$core = Core::getInstance();
$core->db = Object::factory($db);


