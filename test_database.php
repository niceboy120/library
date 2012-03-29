<?php

require_once 'library/jream/Autoload.php';

new jream\Autoload('library/jream/');

$db = array(
	'type' => 'mysql'
	,'host' => 'localhost'
	,'name' => 'test'
	,'user' => 'root'
	,'pass' => ''
);


new jream\Database($db);