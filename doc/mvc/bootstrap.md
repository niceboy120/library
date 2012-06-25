# Boostrap
**JREAM Library**

To run the MVC pattern you begin with an empty file utilizing the bootstrap:

    <?php
    require_once 'jream/autoload.php';

    new jream\Autoload('jream/');


    $bootstrap = new jream\MVC\Bootstrap();
    
	// Always set the Path Root
	$bootstrap->setPathRoot(getcwd());
    // Optional: Default is controller
    $bootstrap->setPathController('controller/');
    // Optional: Default is model
    $bootstrap->setPathModel('model/');
    // Optional: Default is view
    $bootstrap->setPathView('view/');
	// Optional: Set the default controller (Default is: index)
	$bootstrap->setControllerDefault('home');
    // Run the Bootstrap
    $bootstrap->init();
    
To use the Bootstrap with your site you need to pass a URL parameter like this:

    // base url
    http://workspace/index.php?
    // load a controller (defaults to index method)
    http://workspace/index.php?url=controller/method/
    // load a controller with arguments
    http://workspace/index.php?url=controller/method/arg1/arg2/arg3
    
For clean URL's with mod_rewrite you might want an .htaccess file with

    RewriteEngine On
    RewriteBase /mvc/
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-l

    RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
	

To build custom routes use the route class

	$route = new Route(array(
		'category/*' => 'view/category/*',
		'file/*' => 'view/file/*',
	));
	new jream\Autoload('jream/');
	$bootstrap = new jream\MVC\Bootstrap();
	$reroute = $route->match($bootstrap->uri);
	$bootstrap->setPathRoot(getcwd());
    $bootstrap->setPathController('controller/');
    $bootstrap->setPathModel('model/');
    $bootstrap->setPathView('view/');
	$bootstrap->setControllerDefault('home');
	$bootstrap->init($reroute);

***

Copyright (C), 2011-12 Jesse Boyer (<http://jream.com>)
GNU General Public License 3 (<http://www.gnu.org/licenses/>)