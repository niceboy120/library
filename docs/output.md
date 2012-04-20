# Output
**JREAM Library**

The output class is a convenience wrapper for outputting JSON. This is useful for an XHR(AJAX) rich application.
Here is an example of its usage:

	<?php
	$data = array('name' => 'jesse');
	
Standard JSON output

	jream\Output::json($data);
	
Return a JSON Success package

	jream\Output::success();
	jream\Output::success('Optional Data');
	jream\Output::success(array('Optional' => 'Data'));
	
Success Package Output
	{"success":1,"errorMessage":null,"data":"Optional Data"}

Return the same Package with Error

	jream\Output::error();
	jream\Output::error('Optional Data');
	jream\Output::error(array('Optional' => 'Data'));
	
Error Package Output
    {"success":0,"errorMessage":"Optional Data","data":null}
	
	
***

Copyright (C), 2011-12 Jesse Boyer (<http://jream.com>)
GNU General Public License 3 (<http://www.gnu.org/licenses/>)