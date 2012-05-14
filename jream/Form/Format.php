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
	 * <?php
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
		throw new \jream\Exception(__CLASS__ . ": Invalid formatting: $call (Invalid Function)");
		
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
	
	/**
	 * replace - Replaces values in a string
	 * 
	 * @param string $str String to change
	 * @param string $array Item to change the value to
	 *
	 * @return string
	 * 
	 * @throws \jream\Exception 
	 */
	function replace($str, $param)
	{
		if (count($param) != 2)
		throw new \jream\Exception(__FUNCTION__ . ': $param must have two values: find, replace')	;
		
		return str_replace($param[0], $param[1], $str);
	}
	
	/**
	 * iftrue - If the value is set, change the value to the parameter
	 *
	 * @param string $str String to change
	 * @param string $array Item to change the value to
	 *
	 * @return string
	 */
	function iftrue($str, $param)
	{
		if (!empty($str))
		return $param[0];
	}
	
	/**
	 * iffalse - If the value is not set, change the value to the parameter
	 *
	 * @param string $str String to change
	 * @param string $array Item to change the value to
	 *
	 * @return string
	 */
	function iffalse($str, $param)
	{
		if (empty($str))
		return $param[0];
	}
	
	/**
	 * ifgt - If greater than, replace with ..
	 * 
	 * @param mixed $str Integer will compare value, String will compare length
	 * @param array $param When greater than, replace value of key 0 with 1
	 * 
	 * @return mixed
	 *
	 * @throws \jream\Exception 
	 */
	function ifgt($str, $param)
	{
		if (count($param) != 2)
		throw new \jream\Exception(__FUNCTION__ . ': $param must have two values: find, replace')	;
		
		if (is_int($str))
		{
			if ($str > $param[0])
			return $param[1];
		}
		if (is_string($str))
		{
			if (strlen($str) > $param[0])
			return $param[1];
		}
	}
	
	/**
	 * iflt - If less than, replace with ..
	 * 
	 * @param mixed $str Integer will compare value, String will compare length
	 * @param array $param When less than, replace value of key 0 with 1
	 * 
	 * @return mixed
	 *
	 * @throws \jream\Exception 
	 */
	function iflt($str, $param)
	{
		if (count($param) != 2)
		throw new \jream\Exception(__FUNCTION__ . ': $param must have two values: find, replace');

		if (is_int($str))
		{
			if ($str > $param[0])
			return $param[1];
		}
		if (is_string($str))
		{
			if (strlen($str) > $param[0])
			return $param[1];
		}
	}
	
	/**
	 * ifeq - If equals than, replace with ..
	 * 
	 * @param mixed $str Integer will compare value, String will compare value
	 * @param array $param When equal, replace value of key 0 with 1
	 * 
	 * @return mixed
	 *
	 * @throws \jream\Exception 
	 */
	function ifeq($str, $param)
	{
		if (count($param) != 2)
		throw new \jream\Exception(__FUNCTION__ . ': $param must have two values: find, replace');

		if (is_int($str))
		{
			if ($str == $param[0])
			return $param[1];
		}
		if (is_string($str))
		{
			if ($str == $param[0])
			return $param[1];
		}
	}
}