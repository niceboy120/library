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
		return $this->_formatTable($result, $tableName);
	}
	
	/**
	 * tableBuild - Build the table with an existing result set
	 * 
	 * @param array $result Multidimensional array of results
	 * @param string $tableName Prefix for the classes
	 * 
	 * @return string 
	 */
	public function tableQuery($result, $tableName = 'mytable')
	{
		return $this->_formatTable($result, $tableName);
	}
	
	/**
	 * _formatTable - Generates an HTML table
	 * 
	 * @param array $data Array of data
	 * @param string $tableName The name of the table so css can be added 
	 * 
	 * @return mixed Boolean or String
	 */
	private function _formatTable($data, $tableName)
	{
		if (empty($data))
		return false;
		
		$output = "<table id='{$tableName}_table'>";

		$array_keys = array_keys($data[0]);

		$output .= '<thead><tr>';
		foreach ($array_keys as $k => $v) {
			$output .= "<td class='{$tableName}_{$v}'>" . $v . '</td>';
		}
		$output .= '</thead></tr><tbody>';

		/** Loop the Results */
		foreach ($data as $rKey => $rVal) {
			$i = 0;
			$output .= "<tr class='{$tableName}_row_{$i}'>";
			/** Loop the keys for the results */
			
			foreach ($array_keys as $k) {
				$output .= "<td class='{$tableName}_{$k}_{$i}'>" . $rVal[$k] . '</td>';
				
			}
			$i++;
			$output .= '</tr>';
		}
		$output .= '</tbody></table>';
		return $output;	
	}
	
}