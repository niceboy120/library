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
class Timer
{

	/**
	* @var array $_timer Collection of timers
	*/
	private static $_timer = array();

	/**
	 * start - Start a timer
	 *
	 * @param string $id The id of the timer to start
	 */
	public static function start($id)
	{
		if (isset(self::$_timer[$id]))
		throw new Exception("Timer already set: $id");
		
		self::$_timer[$id] = microtime();
	}
	
	/**
	 * stop - Stop a timer
	 *
	 * @param string $id The id of the timer to stop
	 */
	public static function stop($id)
	{
		return microtime() - self::$_timer[$id] / 1000;
	}

	
}