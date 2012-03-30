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
class Exception extends \Exception
{
    private $_options;

	/**
	 * __construct - Allows us to pass an array through an exception
	 * 
	 * @param string $message Text
	 * @param array $options Array of messages
	 */
    public function __construct($message, $options = array())
    {
        parent::__construct($message, 0, null);
        $this->_options = $options;
    }

	/**
	 * getOptions - Grabs an Exception that threw an array of options 
	 *
	 * return array
	 */
	public function getOptions() 
	{
		return $this->_options;
	}
}
