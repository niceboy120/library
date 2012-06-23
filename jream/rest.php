<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 *
 */
namespace jream;
class Rest
{

	public $follow_redirects = false;
	
	/**
	* @var string $_method
	*/
	private $_method;
	
	/**
	* @var resource $_connection
	*/
	private $_connection;
	
	/**
	* __construct - Initialize the cURL resource
	*/
	public function __construct()
	{
		$this->connect();
	}
	
	/**
	* connect - Create the internal connection
	*/
	public function connect()
	{
		$this->_connection = curl_init();
	}
	
	/**
	* post - Send a Post
	*
	* @param string $url 
	* @param string $variables Values to post
	*
	* @return string
	*/
	public function post($url, $variables = array())
	{
		curl_setopt($this->_connection, CURLOPT_POST, true);
		curl_setopt($this->_connection, CURLOPT_POSTFIELDS, $variables);
		return $this->request();
	}
	
	/**
	* get - Send a Get
	* 
	* @param string $url
	*
	* @return string
	*/
	public function get($url)
	{
		$this->_method = 'get';
		return $this->request();
	}
	
	/**
	* request - The call 
	*
	* @return string
	*/
	public function request()
	{
		curl_setopt($this->_connection, CURLOPT_URL, $url);
		
		$response = curl_exec($this->_connection);
		curl_close($this->_connection);
		return $response;
	}	
	
}
