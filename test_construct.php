<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 */
require_once 'jream/Autoload.php';

new jream\Autoload('jream/');

//jream\Database::instance();
new jream\Email();
new jream\Form();
jream\Hash::create('sha1', 'hey');
new jream\Log();
new jream\Output();
new jream\Random();
new jream\Registry();
new jream\Session();