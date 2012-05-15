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

// By setting the database in the registry we have access to it from the model from $this->db
//jream\Registry::set('db', new jream\Database()); 

$bootstrap = new jream\MVC\Bootstrap();
$bootstrap->setPathRoot(getcwd());
$bootstrap->setPathController('controller/');
$bootstrap->setPathModel('model/');
$bootstrap->setPathView('view/');
$bootstrap->init();