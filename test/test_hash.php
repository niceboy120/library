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
echo "<b>Without Salt</b>\n";
foreach (hash_algos() as $algo)
{
	echo $algo . ": " . jream\Hash::create($algo, 'password') . "\n";
}

echo '<hr />';
echo "<b>With Salt</b>\n";
foreach (hash_algos() as $algo)
{
	echo $algo . ": " . jream\Hash::create($algo, 'password', 'secret_salted_string!') . "\n";
}



//jream\Output::success('hello');
//jream\Output::json('hello');
