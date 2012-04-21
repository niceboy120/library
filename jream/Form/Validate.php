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
class Validate
{
	
	/**
	 * length - Require min and max length in one call
	 * 
	 * @param string $value
	 * @param array $param
	 * 
	 * @return string For an error
	 * @throws Exception For a malformed argument
	 */
	public function length($value, $param)
	{

		if (!is_array($param) || count($param) != 2)
		throw new Exception(__CLASS__ . ': Length Parameter must be an array of (min/max).');

		$len = strlen($value);

		if ($len < $param[0] || $len > $param[1])
		return "must be between $param[0] and $param[1] characters.";
	}
	
	/**
	 * minlength - Require a minimum length
	 * 
	 * @param string $value
	 * @param integer $param
	 * 
	 * @return string For an error
	 */
	public function minlength($value, $param)
	{
		if (strlen($value) <= $param)
		return "must be atleast $param in length";
	}
	
	/**
	 * maxlength - Require a maximum length
	 * 
	 * @param string $value
	 * @param integer $param
	 * 
	 * @return string For an error
	 */
	public function maxlength($value, $param)
	{
		if (strlen($value) > $param)
		return "must be no more than $param in length";
	}
	
	/**
	 * exact - Require an exact length
	 * 
	 * @param string $value
	 * @param integer $param
	 * 
	 * @return string For an error
	 */
	public function exactlength($value, $param)
	{
		if (strlen($value) != $param)
		return "must be exactly $param in length";
	}
	
	/**
	 * greaterthan - The value must be greater than the param
	 *
	 * @param string $value
	 * @param mixed $param
	 * 
	 * @return string For an error
	 */
	public function greaterthan($value, $param)
	{
		if (!is_int($param))
		throw new Exception(__CLASS__ .": must supply an integer: $method");
		
		if ($value <= $param)
		return "must be greater than $param";
	}
	
	/**
	 * lessthan - The value must be less than the param
	 *
	 * @param string $value
	 * @param mixed $param
	 * 
	 * @return string For an error
	 */
	public function lessthan($value, $param)
	{
		if (!is_int($param))
		throw new Exception(__CLASS__ .": must supply an integer: $method");
		echo $value;
		echo $param;
		if ($value >= $param)
		return "must be less than $param";
	}
	
	/**
	 * match - Make sure a value matches something
	 * 
	 * @param string $value
	 * @param mixed $param
	 * 
	 * @return string For an error
	 */
	public function match($value, $param)
	{
		if ($value !== $param[0])
		return "does not match";
	}
	
	/**
	 * matchAny - Require atleast a single match inside of an array 
	 * 
	 * @todo: This should combine with match, and you can pass an array
	 * 
	 * @param string $value
	 * @param array $param
	 * @param boolean $caseSensitive Default: true
	 * 
	 * @return string For an error
	 */
	public function matchany($value, $param = array(), $caseSensitive = true)
	{
		if ($caseSensitive == false)
		{
			$value = strtolower($value);
			$param = array_map('strtolower', $param);
		}

		if (!is_array($param))
		throw new Exception(__CLASS__ . ': matchAny $param must be any array');
		
		if (!in_array($value, $param))
		return "is not valid";
	}
	
	/**
	 * regex - Require a match of every item
	 * 
	 * @param string $value
	 * @param string $param Regular Expression
	 */
	public function regex($value, $param)
	{
		if (!preg_match($param, $value))
		return 'must match regular expression';
	}
	
	/**
	 * digit - Require a digit
	 * 
	 * @param mixed $value
	 * 
	 * @return string For an error
	 */
	public function digit($value)
	{
		if (!is_numeric($value))
		return 'must be numeric.';
	}
	
	/**
	 * float - Require float value
	 *
	 * @param float $value
	 *
	 * @return string For an error
	 */
	public function float($value)
	{
		if (!is_float($value))
		return 'must be a float.';
	}
	
	/**
	 * boolean - Require boolean value
	 *
	 * @param float $value
	 *
	 * @return string For an error
	 */
	public function boolean($value)
	{
		if (!is_bool($value))
		return 'must be boolean.';
	}
	
	/**
	 * alpha - Require only alphabetical characters
	 * 
	 * @param string $value
	 * 
	 * @return string For an error
	 */
	public function alpha($value)
	{
		if (!ctype_alpha($value))
		return 'must be alphabetical only.';
	}
	
	/**
	 * alphanum - Require only alphanumeric characters
	 * 
	 * @param string $value
	 * 
	 * @return string For an error
	 */
	public function alphanum($value)
	{
		if (!ctype_alnum($value))
		return 'must be alphanumeric only.';
	}
	
	/**
	 * email - Require an email
	 * 
	 * @param string $value
	 * 
	 * @return string For an error
	 */
	public function email($value)
	{
		if (!filter_var($value, FILTER_VALIDATE_EMAIL))
		return 'invalid email format.';
	}
	
	/**
	 * __call - Handles non-existant methods
	 * 
	 * @param string $method
	 * @param string $arg
	 * 
	 * @throws Exception
	 */
	public function __call($method, $arg)
	{
		throw new Exception(__CLASS__ .": Does not have any method called: $method");
	}
}