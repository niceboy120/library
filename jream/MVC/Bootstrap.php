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
	 * @var array $_urlValue Values beyond the controller/method
	 */
	private $_urlValue = array();
	
	/**
	 * @var string $_pathModel Where the models are located
	 */
	private $_pathModel;
	
	/**
	 * @var string $_pathController Where the controllers are located
	 */
	private $_pathController;
	
	/**
	 * @var object _activeController	The currently loaded Controller
	 */ 
	private $_activeController;
	
	/**
	 * @var object _activeView		The currently loaded View
	 */
	private $_activeView;

	/** 
	 * Initializes Controller/Methods 
	 */
	public function __construct() 
	{
				
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

		$this->_initController();
	}
	
	/**
	 * setPathController
	 *
	 * @param string $path Location for the controllers
	 */
	public function setPathController($path)
	{
		$this->_pathController = $path;
	}
	
	/**
	 * setPathModel
	 *
	 * @param string $path Location for the models
	 */
	public function setPathModel($path)
	{
		$this->_pathModel = $path;
	}
	
	/**
	 * setControllerDefault - The default controller to load when nothing is passed
	 *
	 * @param string $controller Name of the controller
	 */
	public function setControllerDefault($controller)
	{
		$this->_controllerDefault = $controller;
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
			
			/** 
			 * Autoload the Model if there is one 
			*/
			$this->controller->setPathModel();
			$this->controller->loadModel($this->_urlController);

			/** Check if a method is in the URL */
			if (isset($this->_urlMethod)) 
			{
				/** First check if a Value is passed, incase it goes into a method */
				if (!empty($this->_urlValue))
				$this->controller->{$this->_urlMethod}($this->_urlValue);
				
				/** Otherwise only load the method with no arguments */
				else
				$this->controller->{$this->_urlMethod}();
			}
			else {
				/** Revert to the default controller */
				$this->controller->index();
			}
		}
		else 
		{
			die(__CLASS__ . ': error (non-existant controller)');
		}
	}

}
