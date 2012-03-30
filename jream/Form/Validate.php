<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 */
namespace jream\Form;
class Validate
{
	public function length($value, $param)
	{
	
		if (!is_array($param) || count($param) != 2)
		throw new Exception(__CLASS__ . ': Length Parameter must be an array of 2.');

		$len = strlen($value);

		if ($len < $param[0] || $len > $param[1]) {
			return "must be between $param[0] and $param[1] characters.";
		}
	}
	
	public function match($value, $param)
	{
		if ($value !== $param[0]) {
			return "does not match";
		}
	}
	
	
	public function digit($value)
	{
		if (!is_numeric($value)) {
			return 'must be numeric.';
		}
	}
	
	public function alpha($value)
	{
		if (!ctype_alpha($value)) {
			return 'must be A-Z only.';
		}
	}
	
	public function email($value)
	{
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
			return 'invalid email format.';
		}
	}
	
	public function __call($method, $arg)
	{
		throw new Exception(__CLASS__ .": Does not have any method called: $method");
	}
}