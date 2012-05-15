# Registry

The registry class is used to store and fetch items within it and retrieve them from anywhere. Here is an example:

    jream\Registry::set('db', new jream\Database($db));
	...
	$db = jream\Registry::get('db');
	
***

Copyright (C), 2011-12 Jesse Boyer (<http://jream.com>)
GNU General Public License 3 (<http://www.gnu.org/licenses/>)