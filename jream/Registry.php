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
class Registry
{

	/** 
	 * @var array $_record Stores records 
	 */
	private static $_record = array();

	/** 
	 * set - Places an item inside the registry record
	 *
	 * @param string $key The name of the item
	 * @param mixed &$item The item to reference
	 */
	public static function set($key, &$item)
	{
		/** This will overwrite key's with the same name */
		self::$_record[$key] = &$item;
	}

	/**
	 * get - Gets an item out of the registry
	 *
	 * @param string $key The name of the stored record
	 *
	 * return mixed
	 */
	public static function get($key)
	{
		if (isset(self::$_record[$key]))
		return self::$_record[$key];

		else 
		return false;
	}
	
}