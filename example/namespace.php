<?php

require '../jream/autoload.php';

use jream\Autoload as Autoload,
	jream\Database as Database,
	jream\Exception as Exception,
	jream\Form as Form,
	jream\Hash as Hash,
	jream\Output as Output,
	jream\Registry as Registry,
	jream\Session as Session;

new Autoload('../jream');


new Form();
$data = 'love';
Registry::set('life', $data);
Session::start();
Session::set('name', 'jesse');
Session::get('name');
Hash::create('md5', 'Hi Mom');
Output::success('test');