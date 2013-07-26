<?php 

require_once('config.php');
require(constant('HOCKEY_INCLUDE_DIR'));
require_once(constant('TWIG_INCLUDE_DIR'));

// initialize TWIG
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader);


$device = Device::detect();
$applicationDirectory = dirname(__FILE__).DIRECTORY_SEPARATOR;
$applications = Application::create($applicationDirectory, $device);

$template = $twig->loadTemplate('index.html');

$params = array(
		'device' => $device,
		'applications' => $applications,
		'baseURL' => $applications[1]->baseURL,
		'company' => constant('HOCKEY_COMPANY')
);

$template->display($params);


?>