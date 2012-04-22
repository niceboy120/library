<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 */
namespace jream\MVC;
class View
{
	/** 
	 * @var array $_tmp Temporary data, primarily for Form values 
	 */
	private $_temporary;

	/**
	 * First checks if temporary form data needs to be placed in the internal variable for fetching.
	 * This also handles the Status messages
	 */
	public function __construct() 
	{
		if (isset($_SESSION['temporary'])) {
			$this->_temporary = unserialize($_SESSION['temporary']);
			unset($_SESSION['temporary']);
		}
		
		if (isset($_SESSION['status'])) {
			$this->_temporary['status'] = $_SESSION['status'];
			unset($_SESSION['status']);
		}
	}
		
	/**
	 * render - Render a template
	 *
	 * @param string $name The name of the page, eg: index/default
	 */
	public function render($name)
	{
		require "$name.php";
	}
	
	/**
	 * setTemporary - Holds temporary field data for use on next-page (Internal Variable), or a page refresh (Session) 
	 *
	 * @param array $array An associative array containing values to set the the View.
	 */
	public function setTemporary(array $array)
	{
		$this->_temporary = $array;
		$_SESSION['temporary'] = serialize($array);
	}
	
	/**
	 * setStatus - Sets status after a form has been posted we can fetch it after a refresh with $this->get('status');
	 *
	 * @param type $str Status Text
	 */
	public function setStatus($str) 
	{
		$this->_temporary['status'] = $str;
		$_SESSION['status'] = $str;
	}
	
	/**
	 * get - Returns a temporary value held in the view
	 *
	 * @param string $name The name of the value 
	 */
	public function get($name)
	{
		if (isset($this->_temporary[$name]))
		return $this->_temporary[$name];
	}
	
}