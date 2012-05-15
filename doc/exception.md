# Exception
**JREAM Library**

The exception class is used to throw arrays in exceptions.
You can pass string with this class like a default Exception, but it's only beneficial to throw an array.
Here is an example of its usage:

	<?php
	/** Standard String Error Message */
	throw new jream\Exception('Regular Error Message');
	
	/** Array Error Message */
	throw new jream\Exception(null, array('error_1', 'error_2');

Catching the exception follows the same principal:

    <?php
	try {
		throw new jream\Exception(null, array('error_1', 'error_2'));
	} catch (jream\Exception $e) {
		print_r($e->getArray());
	}
	
The first argument can be either null or false when throwing an array;

***

Copyright (C), 2011-12 Jesse Boyer (<http://jream.com>)
GNU General Public License 3 (<http://www.gnu.org/licenses/>)