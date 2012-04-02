<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 * @category	Database
 * @example
 * try {
 *    $db = new jream\Database($db);
 *    $db->select("SELECT * FROM user WHERE id = :id", array('id', 25));
 *    $db->insert("user", array('name' => 'jesse'));
 *    $db->update("user", array('name' => 'juicy), "id = '25'");
 *    $db->delete("user", "id = '25'");
 * } catch (Exception $e) {
 *    echo $e->getMessage();
 * }
 */
namespace jream;
class Database
{
	/**
	 * What's the benefit to creating a new instantiation versus extending it?
	 * Seems that I must redeclare a lot of methods to use within the standard PDO package.
	 * If the $_pdo object variable was public, I'd have to make longer calls, such as
	 * $db->pdo->function(); rather than $db->function(); 
	 * Is this only for a potential singleton that I am not very interested in since a Registry does well enough?
	 */
	
	/**
	 * @var resource $_pdo The pdo object
	 */
	private $_pdo;
	
	/**
	 * __construct - Initializes a PDO connection
	 * 
	 * @param array $db An associative array containing the connection settings,
	 *
	 *	$db = array(
	 *		'type' => 'mysql'
	 *		,'host' => 'localhost'
	 *		,'name' => 'test'
	 *		,'user' => 'root'
	 *		,'pass' => ''
	 *	);
	 */
	public function __construct($db)
	{
		try {
			$this->_pdo = new \PDO("{$db['type']}:host={$db['host']};dbname={$db['name']}", $db['user'], $db['pass']);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
	
	/**
	 * select - Run & Return a Select Query
	 * 
	 * @param string $query Build a query with ? marks in the proper order,
	 *		eg: SELECT :email, :password FROM tablename WHERE userid = :userid
	 * 
	 * @param array $bindParams Fields The fields to select to replace the :colin marks,
	 *		eg: array('email' => 'email', 'password' => 'password', 'userid' => 200);
	 * )
	 * @param integer $cacheTime Time to keep inside of memcache (Not Implemented)
	 * 
	 * @return array
	 */
	public function select($query, $bindParams = array(), $cacheTime = null)
	{
		/** Run Query and Bind the Values */
		$sth = $this->_pdo->prepare($query);
		foreach($bindParams as $key => $value)
		{
			$sth->bindValue(":$key", $value);
		}
	
		$sth->execute();
	
		$this->_handleError();
		
		return $sth->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * insert - Convenience method to insert data
	 *
	 * @param string $table	The table to insert into
	 * @param array $data	An associative array of data: field => value
	 * @param boolean $showSQL (Default = false) Show the SQL Code being processed?
	 */
	public function insert($table, $data, $showSQL = false)
	{
		$insertString = $this->_prepareInsertString($data);

		
		/** Output the code for Debugging */
		if ($showSQL == true)
		echo "INSERT INTO $table (`{$insertString['names']}`) VALUES({$insertString['values']})";
		
		
		/** Run Query and Bind the Values */
		$sth = $this->_pdo->prepare("INSERT INTO $table (`{$insertString['names']}`) VALUES({$insertString['values']})");
		foreach ($data as $key => $value)
		{
			$sth->bindValue(":$key", $value);
		}

		$sth->execute();
		$this->_handleError();
		
		return $this->id();
	}
	
	/**
	 * update - Convenience method to update the database
	 * 
	 * @param string $table The table to update
	 * @param array $data An associative array of fields to change: field => value
	 * @param string $where A condition on where to apply this update
	 * @param boolean $showSQL (Default = false) Show the SQL Code being processed?
	 */
	public function update($table, $data, $where, $showSQL = false)
	{
		$updateString = $this->_prepareUpdateString($data);

		/** Output the code for Debugging */
		if ($showSQL == true)
		echo "UPDATE $table SET $updateString WHERE $where";
		
		/** Run Query and Bind the Values */
		$sth = $this->_pdo->prepare("UPDATE $table SET $updateString WHERE $where");
		foreach ($data as $key => $value)
		{
			$sth->bindValue(":$key", $value);
		}

		$result = $sth->execute();
		$this->_handleError();
		return $result;
	}
	
	/**
	* delete - Convenience method to delete rows
	*
	* @param string $table The table to delete from
	* @param string $where A condition on where to apply this call
	* @param boolean $showSQL (Default = false) Show the SQL Code being processed?
	* 
	* @return boolean
	*/
	public function delete($table, $where, $showSQL = false)
	{
		if ($showSQL == true)
		echo "DELETE FROM $table WHERE $where";
		
		return $this->_pdo->exec("DELETE FROM $table WHERE $where");
	}
	
	/**
	 * Just using the defaults
	 */
	public function beginTransaction()
	{
		return $this->_pdo->beginTransaction();
	}
	
	public function rollBack()
	{
		return $this->_pdo->rollBack();
	}
	
	public function commit()
	{
		return $this->_pdo->commit();
	}
	
	public function inTransaction()
	{
		return $this->_pdo->inTransaction();
	}
	
	public function errorCode()
	{
		return $this->errorCode();
	}
	
	public function setAttribute($attr, $val)
	{
		return $this->_pdo->setAttribute($attr, $val);
	}
	
	/**
	* id - Gets the last inserted ID
	 * 
	* @return integer
	*/
	public function id()
	{
		return $this->_pdo->lastInsertId();
	}

	/**
	 * _prepareInsertString - Handles an array and turns it into SQL code
	 * 
	 * @param array $data The data to turn into an SQL friendly string
	 * @return array
	 */
	private function _prepareInsertString($data) 
	{
		ksort($data);
		/** 
		* @ Incoming $data looks like:
		* $data = array('field' => 'value', 'field2'=> 'value2');
		*/
		return array(
			'names' => implode("`, `",array_keys($data)),
			'values' => ':'.implode(', :',array_keys($data))
		);
	}
	
	/**
	 * _prepareUpdateString - Handles an array and turn it into SQL code
	 * 
	 * @param array $data
	 * @return string
	 */
	private function _prepareUpdateString($data) 
	{
		ksort($data);
		/**
		* @ Incoming $data looks like:
		* $data = array('field' => 'value', 'field2'=> 'value2');
		*/

		$fieldDetails = NULL;
		foreach($data as $key => $value)
		{
			$fieldDetails .= "`$key`=:$key, "; /** Notice the space after the comma */
		}
		$fieldDetails = rtrim($fieldDetails, ', '); /** Notice the space after the comma */
		return $fieldDetails;
	}
	
	/**
	* _handleError - Handles errors with PDO and throws an exception.
	*/
	private function _handleError()
	{
		if ($this->_pdo->errorCode() != '00000')
		throw new \Exception("Error: " . implode(',', $this->errorInfo()));
	}
	
}