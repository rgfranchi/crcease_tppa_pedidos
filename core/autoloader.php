<?php

include_once('Psr/autoloader.php');

/** 
 * Carrega a classe utilizando o NAMESPACE<br> 
 * Substitui a raiz TPPA/CORE pela pasta /core.
 * 
*/
spl_autoload_register(function ($class_name) {
	// $preg_match = preg_match('/^TPPA\\\CORE\\\/', $class_name);
	// if (1 === $preg_match) {
	// 	$class_name = preg_replace('/\\\/', '/', $class_name);
	// 	$class_name = preg_replace('/^TPPA\\/CORE\\//', 'core/', $class_name);
	// 	require_once('./'. $class_name . '.php');
	// }
	
	$arr_class = explode('\\', $class_name);

	// echo '<pre>';
	// echo 'LOAD CLASS<br>';
	// var_dump($arr_class);
	// echo '</pre>';

	$root = $arr_class[0];
	if($root === "TPPA") {
		$location = $arr_class[1];
		$path = "./";
		switch($arr_class[1]) {
			case "CORE" :
				$path = 'core/';
				break;
			case "APP":
				$path = 'app/';
				break;
		}
		$class_name = preg_replace('/\\\/', '/', $class_name);
		$class_name = preg_replace('/^'.$root.'\\/'.$location.'\\//', $path, $class_name);
		// echo '/^'.$root.'\\/'.$location.'\\//';
		// var_dump("---------->" . $class_name);
		require_once($class_name . '.php');
	}


});