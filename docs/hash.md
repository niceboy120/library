# Hash
**JREAM Library**

The Hash class is a convenient way to quickly encrypt your data with a better algorithm and optionally a salt.
Here is an example of its usage:

	<?php
	/** Standard hash */
	jream\Hash::create('sha256', 'Secret_Password');
	
	/** Salted Hash */
	jream\Hash::create('sha256', 'Secret_Password', 'Salt_Code');

***

Copyright (C), 2011-12 Jesse Boyer (<http://jream.com>)
GNU General Public License 3 (<http://www.gnu.org/licenses/>)