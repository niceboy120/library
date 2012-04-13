<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 * @category	Database
 */
namespace jream\Database;
class Output
{
	/** @var resource $_db Active database connection */
	private $_db;
	
	/**
	 * __construct - Sets up Output class with an existing database connection
	 * 
	 * @param resource $db Active database object
	 */
	public function __construct(&$db)
	{
		$this->_db = $db;
	}
	
	/**
	 * tableBuild - Output an HTML table of database records
	 * 
	 * @param string $tableName The name of the SQL table
	 * @param integer $limit How many record to show
	 * 
	 * @return string 
	 */
	public function tableBuild($tableName, $limit = 1000)
	{
		$result = $this->_db->select("SELECT * FROM `$tableName` LIMIT $limit");
		return $this->_formatTable($result);
	}
	
	/**
	 * tableBuild - Build the table with an existing result set
	 * 
	 * @param type $result 
	 * @return string 
	 */
	public function tableQuery($result)
	{
		return $this->_formatTable($result);
	}
	
	/**
	 * _formatTable - Generates an HTML table
	 * 
	 * @param array $data Array of data
	 * @return mixed Boolean or String
	 */
	private function _formatTable($data)
	{
		if (empty($data))
		return false;
		
		$output = '<table>';

		$array_keys = array_keys($data[0]);

		$output .= '<thead><tr>';
		foreach ($array_keys as $k => $v) {
			$output .= '<td>' . $v . '</td>';
		}
		$output .= '</thead></tr><tbody>';

		/** Loop the Results */
		foreach ($data as $rKey => $rVal) {
			$output .= '<tr>';
			/** Loop the keys for the results */
			foreach ($array_keys as $k) {
				$output .= '<td>' . $rVal[$k] . '</td>';
			}
			$output .= '</tr>';
		}
		$output .= '</tbody></table>';
		return $output;	
	}
	
}