<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 * 
 * @example
 * try {
 *   throw new jream\Exception(null, array('error' => 'This is an error'));
 * }
 * catch(Exception $e) {
 *   $e->getArray();
 * }
 */
namespace jream;
class Exception extends \Exception
{
	/** 
	 * @var array $_array Error message(s) stored for the exception 
	 */
    private $_array;
	
	/** 
	 * @var array $_message Error String stored for a fallback on the array 
	 */
    private $_message;

	/**
	 * __construct - Allows us to pass an array through an exception
	 * 
	 * @param string $message Pass NULL to skip, Single message
	 * @param array $options Pass NULL or nothing to skip, Array of messages
	 */
    public function __construct($message, $array = null)
    {
        parent::__construct($message, 0, null);
		
		/** 
		 * Handle the string if there is one
		 */
		if (strlen($message) > 0)
		$this->_array = array('generic' => $message);
		
		/** 
		 * Handle the array
		 */
		if (!is_array($array))
		$this->_array = array('generic' => $array);
			
		else
		$this->_array = $array;
    }

	/**
	 * getArray - Grabs an Exception that threw an array of messages 
	 *
	 * @return array
	 */
	public function getArray()
	{
		if (!empty($this->_array))
		return $this->_array;

		elseif(strlen($this->_message) > 0)
		return $this->_message;

		else
		return array('unknown');
	}
}
