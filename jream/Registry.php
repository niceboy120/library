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
class Registry
{

	/** @var array $_record Stores records */
	private static $_record = array();

	/** 
	* set - Places an item inside the registry record
	* @param string $key The name of the item
	* @param mixed &$item The item to reference
	*/
	public static function set($key, &$item)
	{
		self::$_record[$key] = &$item;
	}

	/**
	* get - Gets an item out of the registry
	* @param string $key The name of the item
	*/
	public static function get($key)
	{
		if (isset(self::$_record[$key])) 
		{
			return self::$_record[$key];
		} 
		else 
		{
			throw new Exception("Trying to get record: $key from Registry, it does not exist");
		}
	}
	
}