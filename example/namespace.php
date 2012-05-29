<?php

require '../jream/autoload.php';

use jream\Autoload,
	jream\Database,
	jream\Exception,
	jream\Form,
	jream\Hash,
	jream\Output,
	jream\Registry,
	jream\Session;

new Autoload('../jream');


new Form();
$data = 'love';
Registry::set('life', $data);
Session::start();
Session::set('name', 'jesse');
Session::get('name');
Hash::create('md5', 'Hi Mom');
Output::success('test');