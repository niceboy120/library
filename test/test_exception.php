<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 */

require_once '../jream/Autoload.php';

new jream\Autoload('../jream/');


echo '<pre>';
try {
	throw new jream\Exception('Regular way');
} catch (jream\Exception $e) {
	echo $e->getMessage();
}

echo PHP_EOL;

try {
	throw new jream\Exception(null, array('error_1', 'error_2'));
} catch (jream\Exception $e) {
	print_r($e->getArray());
}

echo PHP_EOL;


try {
	throw new jream\Exception('Throwing jream\Exception and catching with \Exception', array('ignored stuff'));
} catch (Exception $e) {
	print_r($e->getMessage());
}