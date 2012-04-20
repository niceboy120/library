<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 */

require_once 'jream/Autoload.php';

new jream\Autoload('jream/');

/** 
* Drop a pre so the output is readable
*/
echo '<pre>';

/**
* Positive Case
*/
$mimic = array(
	'name' => 'Jesse'
	,'age' => 27
);
	
try {
	$form = new jream\Form($mimic);
	$form	->post('name')
	
			->post('age')
			->validate('digit');

	$form->submit();
	print_r($form->get());
} catch (Exception $e) {
	echo $e->getMessage();
}


/**
* Negative Cases
*/
try {
	$form = new jream\Form(array('name' => 'Jesse'));
	$form	->post('name')
			->validate('minlength', 5);

	$form->submit();
} catch (Exception $e) {
	echo $e->getMessage() . '<br />';
}

try {
	$form = new jream\Form(array('name' => 'Jesse'));
	$form	->post('name')
			->validate('maxlength', 4);
			
	$form->submit();
} catch (Exception $e) {
	echo $e->getMessage() . '<br />';
}