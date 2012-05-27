<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 *
 * Inspired By:
 *
 *		klein	https://github.com/chriso/klein.php 
 *		prggmr	https://github.com/nwhitingx/prggmr
 *
 */
namespace jream;
class Route
{

	public static function create($uri, $method) 
	{
		if (!is_callable($method))
		{
			throw new \jream\Exception(__CLASS__ . ' $method is not callable');
		}
		
		$uri = $_SERVER['REQUEST_URI'];
		print_r($uri);
	}

	
}