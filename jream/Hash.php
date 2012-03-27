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
class Hash
{
	
	
	/**
	 * create - Create an encryption key with a special algorithm and key
	 * @param string $algo The algorithm to use
	 * @param string $string The string to encrypt
	 * @param string $key A salt or HASH_HMAC to apply to the encryption
	 */
	public static function create($algo, $string, $key = null)
	{		
		if ($key == null)
		$ctx = hash_init($algo);
		else
		$ctx = hash_init($algo, HASH_HMAC, $key);

		/** Finalize the output */
		hash_update($ctx, $string);
		return hash_final($ctx);
	}
	
}