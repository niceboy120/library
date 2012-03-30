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
class Hash
{
	
	/**
	 * create - Create an encryption key with a special algorithm and key
	 * 
	 * @param string $algo The algorithm to use
	 * @param string $string The string to encrypt
	 * @param string $key A salt to apply to the encryption
	 *
	 * return string
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