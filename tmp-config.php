<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

# Composer setup
include_once 'packages/autoload.php';
$basePath = str_finish(dirname(__FILE__), '/');

# Path setup
define('ROOT_PATH', $basePath );
define('CONTROLLER_PATH' , ROOT_PATH .'controller/');
define('RESOURCES_PATH' , ROOT_PATH .'resources/');
define('ORM_PATH' , RESOURCES_PATH .'orm/');

# Database setup
define( 'DB_HOST' , '{hostname}' );
define( 'DB_USER' , '{username}' );
define( 'DB_PASS' , '{password}' );
define( 'DB_NAME' , '{database}' );

# Mail settings - config
define('MAIL_SMTP_SERVER', '{smtp-server}');
define('MAIL_SMTP_SERVER_PORT', '{smtp-server-port}');
define('MAIL_SMTP_USERNAME', '{smtp-username}');
define('MAIL_SMTP_PASSWORD', '{smtp-password}');

define('BLADE_VIEWS', ROOT_PATH .'resources/blade/views');
define('BLADE_CACHE', ROOT_PATH .'resources/blade/cache');

use Philo\Blade\Blade;
use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => DB_HOST,
    'database'  => DB_NAME,
    'username'  => DB_USER,
    'password'  => DB_PASS,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();

function loadORM($dir){
	$ffs = scandir($dir);

	foreach($ffs as $ff){
		if($ff != '.' && $ff != '..'){
			if(is_dir($dir.'/'.$ff)) {
				loadORM($dir.'/'.$ff);
			} else {
				require($dir .'/'. $ff);
			}
		}
	}
}

loadORM(ORM_PATH);
?>
