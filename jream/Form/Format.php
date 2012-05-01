<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 * @category	Form
 */
namespace jream\Form;
class Format
{

	/**
	 * call - Run any PHP function to format
	 * 
	 * @param string $call
	 * @param string $param
	 * 
	 * @return string
	 * 
	 * @throws Exception Upon invalid function
	 */
	public function __call($call, $param)
	{
		if (!function_exists($call))
		throw new Exception(__CLASS__ . ": Invalid formatting: $call (Invalid Function)");
		
		else
		return call_user_func($call, $param[0]);
	}

	/**
	 * upper - Shortcut
	 *
	 * @param string $str String to format
	 *
	 * @return string
	 */
	function upper($str)
	{
		return strtoupper($str);
	}

	/**
	 * lower - Shortcut
	 *
	 * @param string $str String to format
	 *
	 * @return string
	 */	
	function lower($str)
	{
		return strtolower($str);
	}	
	
}