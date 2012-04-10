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
* Bust out a database connection
*/
$config = array(
	'type' => 'mysql'
	,'host' => 'localhost'
	,'name' => 'jream_test'
	,'user' => 'root'
	,'pass' => ''
);

$db = new jream\Database($config);

/** 
* Drop a pre so the output is readable
*/
echo '<pre>';

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
	
	$this->db->insert('user', $form->get());
	
} catch (Exception $e) {
	echo $e->getMessage();
}

