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
	 * @var array $_viewQueue
	 */
	private $_viewQueue = array();

	/**
	 * @var string $_path
	 */
	private $_path;
	
	/**
	 * __construct
	 */
	public function __construct() {}
	
	/**
	 * render - Render a template
	 *
	 * @param string $name The name of the page, eg: index/default
	 */
	public function render($name)
	{
		$this->_viewQueue[] = $name;
	}
	
	/**
	 * setPath - Called from the Bootstrap
	 *
	 * @param string $path Location for the models
	 */
	public function setPath($path)
	{
		$this->_path = $path;
	}
	
	/**
	 * __destruct - Required the files when view is destroyed
	 */
	public function __destruct()
	{
		foreach($this->_viewQueue as $vc)
		{
			echo $this->_path;
			echo $vc;
			require $this->_path . $vc . '.php';
		}
	}
	
}