<?php

require '../jream/Autoload.php';

new jream\Autoload('../jream');

use jream\Output as Output;
use jream\Form as Form;

$f = new Form(array('test' => 'dog'));
Output::success('test');