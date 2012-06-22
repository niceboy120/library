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

if (isset($_REQUEST['run']))
{
	try {
		$form = new jream\Form();
		$form	->post('name')
				->post('agree')
				->format('checkbox')
				->post('box')
				->validate('length', array(1,25));
		$form->submit();
		
		$data = $form->get();
		print_r($data);
		
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}

?>

<form action="?run" method="post">
	<input type="text" name="name" value="Jesse" />
	<input type="checkbox" name="agree" />
	<input type="text" name="box" />
	<input type="submit" />
</form>