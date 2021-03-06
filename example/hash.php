<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 */
require_once '../jream/autoload.php';

new jream\Autoload('../jream/');

echo '<pre>';
echo "<b>Without Salt</b>" . PHP_EOL;

foreach (hash_algos() as $algo)
{
	echo $algo . ": " . jream\Hash::create($algo, 'password') . PHP_EOL;
}

echo PHP_EOL;

echo "<b>With Salt</b>" . PHP_EOL;
foreach (hash_algos() as $algo)
{
	echo $algo . ": " . jream\Hash::create($algo, 'password', 'secret_salted_string!') . PHP_EOL;
}



//jream\Output::success('hello');
//jream\Output::json('hello');
