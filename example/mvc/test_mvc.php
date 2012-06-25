<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 */
require_once '../../jream/autoload.php';

new jream\Autoload('../../jream/');

use jream\MVC\Route,
		jream\MVC\Bootstrap;
// By setting the database in the registry we have access to it from the model from $this->db
//jream\Registry::set('db', new jream\Database()); 


/**
 * Init Routes for custom routes
 */
$route = new Route(array(
	/** 
	 * Mask => With 
	 */
	'category/*' => 'view/category/*',
	'file/*' => 'view/file/*',
));


/**
 * Init MVC
 */
$bootstrap = new Bootstrap();

/**
 *See if there is a route match 
 */
$reroute = $route->match($bootstrap->uri);
$bootstrap->setPathRoot(getcwd());
$bootstrap->setPathController('controller/');
$bootstrap->setPathModel('model/');
$bootstrap->setPathView('view/');
$bootstrap->setControllerDefault('index');
$bootstrap->init($reroute);