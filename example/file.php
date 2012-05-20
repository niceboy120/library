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

if (isset($_REQUEST['run'])) {
	try {
		$file = new jream\Form\File();
//		$file->upload('uploadHere', 'uploaded/'); // Default name
//		$file->upload('uploadHere', 'uploaded/', 'custom_name'); // Custom name
		$file->upload('uploadHere', 'uploaded/', 'custom_name', true); // Overwrite
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}

?>

<form method="post" action="?run" enctype="multipart/form-data">
	<input type="file" name="uploadHere" />
	<input type="submit" />
</form>