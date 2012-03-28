<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (c), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 * @link		http://jream.com
 *
 * This program is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details:
 * http://www.gnu.org/licenses/
 */
namespace jream;
class Database
{
	
	/**
	 * @var resource $_pdo The pdo object
	 */
	private $_pdo;
	
	/**
	 * @var resource $_mc Memcache object
	 */
	private $_mc;
	
	/**
	 * @var resource $_instance For a singleton
	 */
	protected static $_instance = null;
	
	/**
	 * __construct - Initializes a PDO connection
	 * 
	 * @param array $setting An associative array containing the connection settings,
	 *		Required: type, name, host, user, pass
	 */
	protected function __construct()
	{
		try {
//			$this->_mc = new Memcache();
//			$this->_mc->connect('127.0.0.1', 11211);
			
			$this->_pdo = new \PDO('mysql:dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASS);
		} catch (PDOException $e) {
			die('Problem Connecting: ' . $e->getMessage());
		}
	}
	
	/**
	 * instance - Fetch the database instance (Singleton)
	 * 
	 * @return resource
	 */
	public static function instance()
	{
		if (null == self::$_instance) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	/**
	 * select - Run & Return a Select Query
	 * 
	 * @param string $query Build a query with ? marks in the proper order,
	 *		eg: SELECT ?, ? FROM tablename WHERE userid = ?
	 * 
	 * @param array $bindParams Fields The fields to select to replace the ? marks,
	 *		eg: array('email', 'password', 25);
	 * )
	 * @param integer $cacheTime Time to keep inside of memcache
	 * @return type 
	 */
	public function select($query, $bindParams = array(), $cacheTime = null)
	{
		/** Create a unique memcached code */
		$memcacheCode = sha1($query . implode('|', $bindParams));		
		$cacheTime;
//		$existing = $this->_mc->get($memcacheCode);
		
		if (isset($existing)) 
		{
			echo 'fetched mc record';
			return $existing;
		}
		else 
		{
			$sth = $this->_pdo->prepare($query);
			foreach($bindParams as $key => $value)
			{
				$sth->bindValue(":$key", $value);
			}
		
			$sth->execute();
		
			$this->_handleError();
			
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);	
			
//			$this->_mc->add($memcacheCode, $result, MEMCACHE_COMPRESSED, $cacheTime);
		}
		
		return $result;		
	}

	/**
	* insert - Convenience method to insert data
	*
	* @param string $table	The table to insert into
	* @param array $data	An associative array of data: field => value
	*/
	public function insert($table, $data)
	{
		$insertString = $this->_prepareInsertString($data);

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
	*/
	public function update($table, $data, $where)
	{
		$updateString = $this->_prepareUpdateString($data);

		$sth = $this->_pdo->prepare("UPDATE $table SET $updateString WHERE $where");

		foreach ($data as $key => $value)
		{
			$sth->bindValue(":$key", $value);
		}

		$sth->execute();
		$this->_handleError();
	}
	
	/**
	* delete - Convenience method to delete rows
	*
	* @param string $table The table to delete from
	* @param string $where A condition on where to apply this call
	* @return boolean
	*/
	public function delete($table, $where)
	{
		return $this->_pdo->exec("DELETE FROM $table WHERE $where");
	}
	
	/**
	 * Just using the defaults
	 */
	public function beginTransaction()
	{
		$this->_pdo->beginTransaction();
	}
	
	public function rollBack()
	{
		$this->_pdo->rollBack();
	}
	
	public function commit()
	{
		$this->_pdo->commit();
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