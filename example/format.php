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

$format = new jream\Form\Format();

echo $format->number_format(500, 2);

echo "<br />";

echo $format->htmlentities('<b>Testing</b>');

echo "<br />";

/**
 * There is a replace method so this isn't really necessary: 
 */
echo $format->str_replace('T', 'Z', 'This is a Test Okay');

echo "<br />";

echo $format->replace('This is my life', array('i', 'X'));
