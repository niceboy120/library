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

	private $_viewQueue = array();

	public function __construct() 
	{
	}
		
	/**
	 * render - Render a template
	 *
	 * @param string $name The name of the page, eg: index/default
	 */
	public function render($name)
	{
		$this->viewQueue[] = $name;
		require "$name.php";
	}
	
	
	public function __destruct()
	{
		foreach($viewQueue as $vc)
		{
			require $vc . '.php';
		}
	}
	
}