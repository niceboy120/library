<?php

require_once 'library/jream/Autoload.php';

new jream\Autoload('library/jream/');

//jream\Database::instance();
new jream\Email();
new jream\Form();
jream\Hash::create('sha1', 'hey');
new jream\Log();
new jream\Output();
new jream\Random();
new jream\Registry();
new jream\Session();