<?php
	header('Content-Type: text/html');

	ob_start();


	/**
	 * Azerbaijan/Baku time zone
	 */

	date_default_timezone_set('Asia/Baku');


	/**Twig*/

	require dirname(__DIR__) . '/vendor/autoload.php';

	/**Autoloader*/

	spl_autoload_register(function($class){

		$root = dirname(__DIR__); // get the parent directory
		$file = $root .'/'.str_replace('\\', '/', $class).".php";

		if (file_exists($file) && is_readable($file)) {

			require $root.'/'.str_replace('\\','/',$class).".php";

		}
	});

	/**
	 * Error and Exception handling
	*/

	set_error_handler('Core\Error::errorHandler');
	set_exception_handler('Core\Error::exceptionHandler');
	error_reporting(E_ALL);

	/**
	 *  Session
	*/

	session_start();

	/**
	 * Routing
	*/
	$router = new Core\Router();
	// Add the Routes
	// Route Table

	$router->add('', ['controller' => 'Home', 'action' => 'index']);
	$router->add('home', ['controller' => 'Home', 'action' => 'index']);
	$router->add('login',['controller'=>'Login','action'=>'new']);
	$router->add('logout',['controller'=>'Login','action'=>'destroy']);
	$router->add('signup',['controller'=>'Signup','action'=>'new']);
	$router->add('{controller}/{action}');
	$router->add('{controller}/{id:\d+}/{action}');
	$router->add('password/reset/{token:[\da-f]+}',['controller'=>'Password','action'=>'reset']);
	$router->add('signup/activate/{token:[\da-f]+}',['controller'=>'Signup','action'=>'activate']);
	$router->add("Admin",["namespace"=>'Admin',"controller"=>"home","action"=>"show"]);
	$router->add('Admin/{controller}/{action}', ['namespace'=>'Admin']);
	$router->add('Admin/{controller}/{action}/{id:\d+}', ['namespace'=>'Admin']);

	$url = $_SERVER['QUERY_STRING'] ;

	$router->dispatch(trim($url,'/'));

?>
