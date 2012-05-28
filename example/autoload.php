<?php

require '../jream/autoload.php';

new jream\Autoload('../jream/');

new jream\Form;
jream\Hash::create('sha256', 1);


$directory = '../jream/';
$iterator = new DirectoryIterator($directory);

foreach ($iterator as $fileinfo) {
	if ($fileinfo->isFile()) {
		$fileinfo->getFilename();
	}
}

function iterator($dir) {
	$iterator = new DirectoryIterator($dir);
	foreach ($iterator as $fileinfo) {
		if ($fileinfo->isFile()) {
			echo $fileinfo->getFilename();
			echo '<br />';
		}
		elseif ($fileinfo->isDir() && !$fileinfo->isDot())
		{
			echo $fileinfo->getPathName();
			iterator($fileinfo->getPathName());
			echo '<br />';
		}
	}
}

iterator($directory);

echo '<pre>';	