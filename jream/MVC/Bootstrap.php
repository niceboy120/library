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
class Bootstrap 
{

	/**
	 * @var string $_controllerDefault The default controller to load
	 */
	private $_controllerDefault = 'index';
	
	/**
	 * @var string $_urlController The controller to call
	 */
	private $_urlController;
	
	/**
	 * @var string $_urlMethod The method call
	 */
	private $_urlMethod;
	
	/**
	 * @var array $this->_urlValue Values beyond the controller/method
	 */
	private $_urlValue = array();
	
	/**
	 * @var string $_pathModel Where the models are located
	 */
	private $_pathModel = 'model';
	
	/**
	 * @var string $_pathView Where the views are located
	 */
	private $_pathView = 'view';
	
	/**
	 * @var string $_pathController Where the controllers are located
	 */
	private $_pathController = 'controller';
	
	/**
	 * @var object _basePath The basepath to include files from
	 */ 
	private $_basePath;

	/** 
	 * init - Initializes the bootstrap handler once ready
	 */
	public function init() 
	{
		if (!isset($this->_pathRoot)) 
		die('You must run setPathRoot($path)');
				
		if (isset($_GET['url']))
		{	
			/** Prevent the slash from breaking the array below */
			$url = rtrim($_GET['url'], '/');
			
			/** Prevent a null-byte from going through */
			$url = filter_var($url, FILTER_SANITIZE_URL);
			
			/** Break up the URL */
			$url = explode('/', $url);
						
			/** Grab Controller and Optional Method */
			$this->_urlController = ucwords($url[0]); // Make sure its matches naming ie: Index_Controller
			$this->_urlMethod = (isset($url[1])) ? strtolower($url[1]) : NULL;

			/** Grab the urlValues beyond the point of controller/method/ */
			$this->_urlValue = array_splice($url, 2);
		
			unset($url);
		}

		/** The order of these are important */
		$this->_initView();
		$this->_initModel();
		$this->_initController();
	}
	
	/**
	 * setPathBase - Required
	 * 
	 * @param type $path Location of the root path
	 */
	public function setPathRoot($path)
	{
		$this->_pathRoot = trim($path, '/') . '/';
	}
	
	/**
	 * setPathController - Default is 'controller'
	 *
	 * @param string $path Location for the controllers
	 */
	public function setPathController($path)
	{
		$this->_pathController = $this->_pathRoot . trim($path, '/') . '/';
	}
	
	/**
	 * setPathModel - Default is 'model'
	 *
	 * @param string $path Location for the models
	 */
	public function setPathModel($path)
	{
		$this->_pathModel = $this->_pathRoot . trim($path, '/') . '/';
	}
	
	/**
	 * setPathView - Default is 'view'
	 *
	 * @param string $path Location for the models
	 */
	public function setPathView($path)
	{
		$this->_pathView = $this->_pathRoot . trim($path, '/') . '/';
	}
	
	/**
	 * setControllerDefault - The default controller to load when nothing is passed
	 *
	 * @param string $controller Name of the controller
	 */
	public function setControllerDefault($controller)
	{
		$this->_controllerDefault = strtolower($controller);
	}
	
	/** 
	 * _initController - Load the controller based on the URL 
	 */
	private function _initController() 
	{
		/** Default to the index controller if one is not set in the URL */
		if (!isset($this->_urlController))
		$this->_urlController = $this->_controllerDefault;
		
		/** Make sure the actual controller exists */
		if (file_exists($this->_pathController . $this->_urlController . '.php')) 
		{
		
			/** Include the controller and instantiate it */
			require $this->_pathController . $this->_urlController . '.php';
			
			$controller = $this->_urlController;
			$this->controller = new $controller();

			/** Check if a method is in the URL */
			if (isset($this->_urlMethod))
			{
				/** First check if a Value is passed, incase it goes into a method */
				if (!empty($this->_urlValue))
				{
					switch (count($this->_urlValue))
					{
						case 1:
						$this->controller->{$this->_urlMethod}($this->_urlValue[0]);
						break;
					
						case 2:
						$this->controller->{$this->_urlMethod}($this->_urlValue[0], $this->_urlValue[1]);
						break;
							
						case 3:
						$this->controller->{$this->_urlMethod}($this->_urlValue[0], $this->_urlValue[1], $this->_urlValue[2]);
						break;
					
						case 4:
						$this->controller->{$this->_urlMethod}($this->_urlValue[0], $this->_urlValue[1], $this->_urlValue[2], $this->_urlValue[3]);
						break;
					
						case 5:
						$this->controller->{$this->_urlMethod}($this->_urlValue[0], $this->_urlValue[1], $this->_urlValue[2], $this->_urlValue[3], $this->_urlValue[4]);
						break;
					}
				}
				
				/** Otherwise only load the method with no arguments */
				else
				$this->controller->{$this->_urlMethod}();
			}
			else {
				/** Revert to the default controller's main function */
				$this->controller->index();
			}
		}
		else 
		{
			die(__CLASS__ . ': error (non-existant controller)');
		}
	}
	
	/** 
	 * _initModel - Autoload the Model if there is one 
	 */
	private function _initModel()
	{
		$actualModel = $this->_pathModel . $this->_urlController . '_model.php';
		
		if (file_exists($actualModel))
		{
			require $actualModel;
			$model = (string) $this->_urlController . '_model';
			$model = (object) new $model();
			\jream\Registry::set('model', $model);
		}
	}
	
	private function _initView()
	{
		$view = new View();
		$view->setPath($this->_pathView);
		\jream\Registry::set('view', $view);
	}
	
}
