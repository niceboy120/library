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
	public function __call($call, $unlimitedParams)
	{
		if (!function_exists($call))
		throw new \jream\Exception(__CLASS__ . ": Invalid formatting: $call (Invalid Function)");
	
		$args = func_get_args();
		$param = $args[1];
		/**
		 * Count the arguments beyond the call 
		 */
		switch (count($param))
		{
			case 2:
				return call_user_func($call, $param[0], $param[1]);
				break;
			case 3:
				return call_user_func($call, $param[0], $param[1], $param[2]);
				break;
			case 4:
				return call_user_func($call, $param[0], $param[1], $param[2], $param[3]);
				break;
			default:
				return call_user_func($call, $param[0]);
		}
	}

	/**
	 * upper - Shortcut
	 *
	 * @param string $str String to format
	 *
	 * @return string
	 */
	public function upper($str)
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
	public function lower($str)
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
	public function replace($str, $param)
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
	public function iftrue($str, $param)
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
	public function iffalse($str, $param)
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
	public function ifgt($str, $param)
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
	public function iflt($str, $param)
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
	public function ifeq($str, $param)
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
	
	/**
	 * checkbox - Formats a checkbox to a 1 or 0 if its ticked
	 *
	 * @param string $str 
	 */
	public function checkbox($str)
	{
		if ($str == 'on')
		return 1;
		
		else
		return 0;
	}
	
	/**
	 * toint - Cast to an integer
	 * 
	 * @param string $str
	 * 
	 * @return integer
	 */
	public function toint($str)
	{
		return (integer) $str;
	}
	
	/**
	 * tostr - Cast to string
	 * 
	 * @param string $str
	 * 
	 * @return string
	 */
	public function tostr($str)
	{
		return (string) $str;
	}
	
	/**
	 * slug - Formats to a URL friendly slug
	 * 
	 * @param string $str
	 * 
	 * @return string
	 */
	public function slug($str)
	{
		$str = strtolower($str);
		$str = preg_replace('/[^a-z0-9_\s-]/', '', $str);
		$str = preg_replace("/[\s-]+/", " ", $str);
		$str = preg_replace("/[\s_]/", "-", $str);
		return (string) $str;
	}
	
	/**
	 * regex - Run a replacement with a regex pattern (preg_replace)
	 * 
	 * @param string $str
	 * @param array $param The Regular Expression and Replacements
	 * 
	 * @return string
	 * 
	 * @throws \jream\Exception 
	 */
	public function regex($str, $param)
	{
		if (count($param) != 2)
		throw new \jream\Exception(__FUNCTION__ . ': $param must have two values: regex');
				
		return preg_replace($param[0], $param[1], $str);
	}
	
}