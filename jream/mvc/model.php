<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 */
namespace jream\MVC;
class Model
{

	/** @var object $db The jream Database object */
	public $db;

	/**
	* __construct - Include database object if defined
	*/
	public function __construct()
	{
		$this->db = \jream\Registry::get('db');
	}
	
}