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

// For some JS money money money...
try {
	$form = new jream\Form();
	$form	->post('name', true)
			->validate('maxlength', 4)
			->error('This is a custom error message')
			
			->post('age', true)
			->validate('eq', 12)
			->error('So this is not matching!')
			
			->post('gender', true)
			->validate('eq', 'f');
	
	//print_r($form->get());
	
	$form->submit();
} catch (jream\Exception $e) {
	$z = $e->getArray();
	jream\Output::error($z);
}