<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 * @example
 * $crud = new Crud(new Database($db));
 * $crud->load('table');
 */
namespace jream;
class Crud
{

	/**
	 * __construct - Prepare the Crud system
	 *
	 * @param object $db Database object with a connection established
	 */
	public function __construct(Database $db)
	{
		$this->db = $db;
	}
	
	public function load($table)
	{
		$this->db->query("SHOW COLUMNS FROM `$table`");
	}
	
	public function create() {}
	public function update() {}
	public function delete() {}
	public function select() {}
	
}