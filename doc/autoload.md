# Autoload
**JREAM Library**

This class is used to autoload any directory upon instantiation.
Example of using the Autoloader:

	<?php
	require_once 'jream/autoload.php';
    new jream\Autoload('jream/');

Recursion goes one sub-folder deep, that means the deepest it will go is: 

    folder_called/sub_folder/class.php

***

Copyright (C), 2011-12 Jesse Boyer (<http://jream.com>)
GNU General Public License 3 (<http://www.gnu.org/licenses/>)