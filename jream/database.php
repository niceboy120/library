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
class Database extends \PDO
{

	/**
	 * @var boolean $activeTransaction Whether a transaction is going on
	 */
	public $activeTransaction;
	
	/** 
	 * @var constant $_fetchMode The select statement fetch mode 
	 */
	private $_fetchMode = \PDO::FETCH_ASSOC;
	 
	/**
	 * __construct - Initializes a PDO connection (Two ways of connecting)
	 * 
	 * @param array $db An associative array containing the connection settings,
	 * @param string $type Optional if using arugments to connect
	 * @param string $host Optional if using arugments to connect
	 * @param string $name Optional if using arugments to connect
	 * @param string $user Optional if using arugments to connect
	 * @param string $pass Optional if using arugments to connect
	 *
	 *  // First Way:
	 *	$db = array(
	 *		'type' => 'mysql'
	 *		,'host' => 'localhost'
	 *		,'name' => 'test'
	 *		,'user' => 'root'
	 *		,'pass' => ''
	 *	);
	 *  $db = new jream\Database($db);
	 *
	 *  // Second Way:
	 *  $db = new jream\Database(null, 'mysql', 'localhost', 'test', 'root', '');
	 */
	public function __construct($db, $type = null, $host = null, $name = null, $user = null, $pass = null)
	{
		try {
			/** Connect with arguments */
			if ($db == false || $db == null)
			{
				parent::__construct("{$type}:host={$host};dbname={$name}", $user, $pass);
			}
			/** Connect with assoc array */
			else
			{
				parent::__construct("{$db['type']}:host={$db['host']};dbname={$db['name']}", $db['user'], $db['pass']);
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
	
	/**
	 * setFetchMode - Change the default mode for fetching a query
	 *
	 * @param constant $fetchMode Use the PDO fetch constants, eg: \PDO::FETCH_CLASS
	 */
	public function setFetchMode($fetchMode)
	{
		$this->_fetchMode = $fetchMode;
	}
	
	/**
	 * select - Run & Return a Select Query
	 * 
	 * @param string $query Build a query with ? marks in the proper order,
	 *	eg: SELECT :email, :password FROM tablename WHERE userid = :userid
	 * 
	 * @param array $bindParams Fields The fields to select to replace the :colin marks,
	 *	eg: array('email' => 'email', 'password' => 'password', 'userid' => 200);
	 *
	 * @param constant $overrideFetchMode Pass in a PDO::FETCH_MODE to override the default or the setFetchMode setting
	 *
	 * @return array
	 */
	public function select($query, $bindParams = array(), $overrideFetchMode = null)
	{
		/** Run Query and Bind the Values */
		$sth = $this->prepare($query);
		foreach($bindParams as $key => $value)
		{
			$sth->bindValue(":$key", $value);
		}
	
		if ($sth->execute() == false) {
			throw new jream\Exception(__CLASS__ .'::'. __FUNCTION__ . " did not execute properly");
		}
	
		/** Throw an exception for an error */
		$this->_handleError();
		
		/** Automatically return all the goods */
		if ($overrideFetchMode != null)
		return $sth->fetchAll($overrideFetchMode);
		else
		return $sth->fetchAll($this->_fetchMode);
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
	
		/** Prepare SQL Code */
		$insertString = $this->_prepareInsertString($data);

		/** Output the code for Debugging */
		if ($showSQL) echo "INSERT INTO $table (`{$insertString['names']}`) VALUES({$insertString['values']})";
		
		/** Run Query and Bind the Values */
		$sth = $this->prepare("INSERT INTO $table (`{$insertString['names']}`) VALUES({$insertString['values']})");
		foreach ($data as $key => $value)
		{
			$sth->bindValue(":$key", $value);
		}

		if ($sth->execute() == false) {
			throw new jream\Exception(__CLASS__ .'::'. __FUNCTION__ . " did not execute properly");
		}
		
		/** Throw an exception for an error */
		$this->_handleError();
		
		/** Return the insert id */
		return $this->lastInsertId();
	}
	
	/**
	 * update - Convenience method to update the database
	 * 
	 * @param string $table The table to update
	 * @param array $data An associative array of fields to change: field => value
	 * @param string $where A condition on where to apply this update
	 * @param boolean $showSQL (Default = false) Show the SQL Code being processed?
	 *
	 * @return boolean Successful or not
	 */
	public function update($table, $data, $where, $showSQL = false)
	{
		/** Build the Update String */
		$updateString = $this->_prepareUpdateString($data);

		/** Prepare SQL Code */
		$sql = "UPDATE $table SET $updateString WHERE $where";
		
		/** Optionally output the SQL */
		if ($showSQL) echo $sql;
		
		/** Run Query and Bind the Values */
		$sth = $this->prepare("UPDATE $table SET $updateString WHERE $where");
		foreach ($data as $key => $value)
		{
			$sth->bindValue(":$key", $value);
		}

		$result = $sth->execute();
		if ($result == false) {
			throw new \Exception(__CLASS__ .'::'. __FUNCTION__ . " did not execute properly");
		}
		
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
	* @return integer Total affected rows
	*/
	public function delete($table, $where, $showSQL = false)
	{
		/** Prepare SQL Code */
		$sql = "DELETE FROM $table WHERE $where";
	
		/** Optionally output the SQL */
		if ($showSQL) echo $sql;
		
		return $this->exec($sql);
	}
		
	/**
	* id - Gets the last inserted ID
	 * 
	 * @return integer
	 */
	public function id()
	{
		return $this->lastInsertId();
	}
	
	/**
	 * beginTransaction - Overloading default method 
	 */
	public function beginTransaction()
	{
		parent::beginTransaction();
		$this->activeTransaction = true;
	}
	
	/**
	 * commit - Overloading default method 
	 */
	public function commit()
	{
		parent::commit();
		$this->activeTransaction = false;
	}
	
	/**
	 * rollback - Overloading default method 
	 */
	public function rollback()
	{
		parent::rollback();
		$this->activeTransaction = false;
	}
	
	/**
	 * showColumns - Display the columns for a table (MySQL)
	 *
	 * @param string $table Name of a MySQL table
	 */
	public function showColumns($table)
	{
		$result = $this->select("SHOW COLUMNS FROM `$table`", array(), \PDO::FETCH_ASSOC);
		
		$output = array();
		foreach ($result as $key => $value)
		{
		
			if ($value['Key'] == 'PRI')
			$output['primary'] = $value['Field'];
			
			$output['column'][$value['Field']] = $value['Type'];
		}
		
		return $output;
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
		if ($this->errorCode() != '00000')
		throw new jream\Exception("Error: " . implode(',', $this->errorInfo()));
	}
	
}