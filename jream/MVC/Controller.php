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
class Controller
{

	/**
	 * @var object $view Set from the bootstrap
	 */
	public $view;
	
	/**
	 * @var object $model Set from the bootstrap
	 */
	public $model;

	/**
	* __construct - Required
	*/
	public function __construct() 
	{
		$this->view = \jream\Registry::get('view');
		$this->model = \jream\Registry::get('model');
	}

	/**
	* location - Shortcut for a page redirect
	*
	* @param string $url 
	*/
	public function location($url)
	{
		header("location: $url");
		exit(0);
	}
	
}