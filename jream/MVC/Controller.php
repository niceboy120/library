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
	* @var boolean $_isViewInstantiated
	*/
	private $_isViewInstantiated = false;

	/**
	 * @var string $_pathModel Path to the models
	 */
	private $_pathModel = 'model';

	public function __construct()
	{
		
	}
	
	/**
	 * setPathModel - Called from the Bootstrap
	 *
	 * @param string $path Location for the models
	 */
	public function setPathModel($path)
	{
		$this->_pathModel = $path;
	}
	
	/**
	 * view - Instanites or serves the view object
	 *
	 * @return object View 
	 */
	public function view()
	{
		if ($_isViewInstantiated == false)
		{
			$this->view = new View();
		}
		else
		{
			return $this->view;
		}
	}
	
	/**
	 * loadModel - Loads the matching model for the controller
	 *
	 * @param string $path Location for the models
	 */
	public function loadModel($model)
	{
	
		$actualModel = $this->_pathModel . $model . '.php';
		
		if (file_exists($actualModel))
		{
			require $actualModel;
			$this->model = new $model;
		}
	}

}