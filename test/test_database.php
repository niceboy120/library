<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 */
require_once '../jream/Autoload.php';

new jream\Autoload('../jream/');

$config = array(
	'type' => 'mysql'
	,'host' => 'localhost'
	,'name' => 'jream_test'
	,'user' => 'root'
	,'pass' => ''
);

echo '<pre>';


$db = new jream\Database($config);

$db->insert('user', array('name' => 'Jesse'));
$db->update('user', array('name' => 'Other'), "userid = '10002'");
$db->delete('user', "userid = '10000'");

$db->setFetchMode(\PDO::FETCH_ASSOC);
$result = $db->select('SELECT * FROM user', array());
print_r($result);

$db->setFetchMode(\PDO::FETCH_CLASS);
$result = $db->select('SELECT * FROM user', array());
print_r($result);

$result = $db->select('SELECT * FROM user', array(), \PDO::FETCH_NUM);
print_r($result);


$cols = $db->showColumns('user');
print_r($cols);