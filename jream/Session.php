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
class Session 
{

	/** @var boolean $_sessionStarted The flag for singleton */
	private static $_sessionStarted = false;

	/**
	* start - Start the SESSION (Singleton)
	*/
	public static function start()
	{
		if (self::$_sessionStarted == false)
		{
			session_start();
			self::$_sessionStarted = true;
		}
	}
	
	/**
	 * set - Sets a session value
	 * @param string $key The name
	 * @param string $value The value 
	 */
	public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	/**
	 * get - Grabs a value from the session
	 
	 * @param string $key the name of the Session KEY
	 * @param string $secondKey the name of a Second Session KEY (Within a Session Multi-Dimensional Array)
	 * @return mixed Either the value or false
	 */
	public static function get($key, $secondKey = false) 
	{
		
		if ($secondKey == true) 
		{
			if (isset($_SESSION[$key][$secondKey]))
			return $_SESSION[$key][$secondKey];
		}
		else 
		{
			if (isset($_SESSION[$key]))
			return $_SESSION[$key];
		}
		
		return false;
	}

	/**
	*	csrf - Generates/Regenerates a CSRF token inside a Session
	
	*	@param integer $seconds Amount of time for the token to live
	*/
	public function csrf($seconds)
	{
		$timeout = self::get('csrf_timeout');
		if (empty($timeout) || $timeout + $seconds < strtotime('now'))
		{
			self::set('csrf', sha1(strtotime('now')));
			self::set('csrf_timeout', strtotime('now'));
		}
	}
	
	/**
	 * display - Display the session with pre tags
	 */
	public static function display() {
		echo '<pre>';
		print_r($_SESSION);
		echo '</pre>';
	}
	

	/**
	* checkLogged - Logs a user out if the $_SESSION['userLogin'] is not set
	*/
	public static function checkLogged()
	{
		if (self::get('userLogin') == false || self::get('session_key') == false || self::get('session_key') !== SESSION_KEY)
		{
			//die('key error');
			self::logout();
		}
	}

	/** 
	* logout - Logs a user out 
	* @param string $controller The page to redirect the user to
	*/
	public static function logout($controller = 'index')
	{
		self::destroy();
		header('Location: ' . URL . $controller);
	}

	/**
	* isLogged - Tells if $_SESSION['userLogin'] is set
	* @return boolean 
	*/
	public static function isLogged()
	{
		if (self::get('userLogin') == false)
		return false;

		else
		return true;
	}

	/**
	* is - Used for checking the type of user
	
	* @param string $userType The type of user (admin, default, etc)
	* @return mixed The userLogin or false
	*/
	public static function is($userType)
	{
		$userType = strtolower(trim($userType));

		if (self::get('userType') == $userType)
		return self::get('userLogin');

		else
		return false;
	}
	
	/**
	 * destroy - Destroy the entire session
	 */
	public static function destroy() {
		if (self::$_sessionStarted == true)
		{
			session_unset();
			session_destroy();
		}
	}

}