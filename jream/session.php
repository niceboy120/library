<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 */
namespace jream;
class Session
{

	/**
	 * start - Starts a session if one doesn't exist
	 */
	public static function start()
	{
		if (session_id() == false)
		{
			session_start();
		}
	}
	
	/**
	 * set - Sets a value inside the session
	 * 
	 * @param string $key The name of the session key
	 * @param string $value The value for the key
	 */
	public static function set($key, $value)
	{
		if (is_string($key))
		{
			$_SESSION[$key] = $value;
		}
		
		if (is_array($key))
		{
			// Not sure yet
		}
		
	}

	/**
	 * get - Retrieves a session value
	 * 
	 * @param string $key The name of the session key
	 * 
	 * @return mixed THe value or false
	 */
	public static function get($key)
	{
		return (isset($_SESSION[$key])) ? $_SESSION[$key] : false;
	}
	
	/**
	 * destroy - Kill the session if one exists
	 */
	public static function destroy()
	{
		if (session_id() == true)
		{
			session_destroy();
		}
	}
	
	/**
	 * dump - Outputs the session for the browser
	 */
	public static function dump()
	{
		if (session_id() == true)
		{
			echo '<pre>';
			print_r($_SESSION);
			echo '</pre>';
		}
	}

}