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

echo '<pre>';
if (isset($_REQUEST['run'])) {
	try {
		$form = new jream\Form();
		$form	->post('title', true)
				->validate('minlength', 2)
				
				->file('uploadHere', 'uploaded/', 'custom_name', false, true);
		
		$form->submit();
	
		echo 'Got beyond the form';
		
	} catch (Exception $e) {
		echo '<b>Error: ' . $e->getMessage() . '</b>';
	}
	
	echo '<b>Debug Form</b>';
	$form->debug();
}
echo '</pre>';
?>

<form method="post" action="?run" enctype="multipart/form-data">
	Title: <input type="text" name="title" /><br />
	<input type="file" name="uploadHere" /><br />
	<input type="submit" />
</form>