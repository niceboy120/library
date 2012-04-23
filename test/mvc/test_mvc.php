<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 */
require_once '../../jream/Autoload.php';

new jream\Autoload('../../jream/');

echo '<pre>';

echo "Call the url: test_mvc.php?url=index/argtest/color/red"  . "\n";
echo "Call the url: test_mvc.php?url=index/modeltest"  . "\n";
$bootstrap = new jream\MVC\Bootstrap();
$bootstrap->setPathController('controller/');
$bootstrap->setPathModel('model/');
$bootstrap->setPathView('view/');
$bootstrap->init();