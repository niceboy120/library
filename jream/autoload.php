<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 * @example
 *
 * require_once '/jream/autoload.php';
 * new jream\Autoload('/jream/');
 */
namespace jream;
class Autoload
{

	/** @var string $_dir Directory to autoload */
	private $_dir;
	
	/** @var boolean $_loadCalled Flag to prevent the load from processing twice */
	private $_loadCalled;
	
	/** @var string $_className The name of this class without the namespace */
	private $_className;
	
	/**
	* Initializes SPL Autoloader
	*
	* @param string $dir The location of the API directory
	*/
	public function __construct($dir)
	{
		$this->i = 0;
		/** Make sure there is always a trailing slash */
		$this->_dir = rtrim($dir, '/').'/';
		
		/** Prevent other autoloaders from collision */
		$beingLoaded = spl_autoload_functions();

		/** Get the autoload classname without the namespace */
		$this->_className = explode('\\', __CLASS__);
		$this->_className = end($this->_className);
		
		if (is_array($beingLoaded))
		{
			if (in_array('__autoload', $beingLoaded)) 
			spl_autoload_register('__autoload');
		}
		
		/**
		* Continue with our normal autoloading
		*/
		spl_autoload_register(array($this, '_load'));
	}
	
	/**
	* _load - Internally loads all necessary classes
	*
	* @param string $class The classname being loaded
	*/
	private function _load($class) 
	{
		/**	Only allow this to load one time to prevent a conflict */
		if ($this->_loadCalled == true)
		return;
	
		/** Run the iteration */
		$this->_iterate($this->_dir);
		
		/** Flag the autoloader as called */
		$this->_loadCalled = true;
	}
	
	/**
	 * _iterate - Loop through a directory
	 *
	 * @param string $directory The path to loop through 
	 */
	private function _iterate($directory)
	{
		/** Create a Directory Iterator */
		$iterator = new \DirectoryIterator($directory);
		
		/** Loop through the files */
		foreach ($iterator as $f)
		{
			/** Require the Files */
			if ($f->isFile())
			{				
				/** Do not include this class name (Autoload) */
				if ($f->getFilename() == strtolower($this->_className) . '.php')
				{
					continue;
				}
				/** Require the file */
				else
				{
					require $directory . '/' . $f->getFilename();
				}
				
			}
			/** Iterate Sub Directory */
			elseif ($f->isDir() && !$f->isDot())
			{
				$this->_iterate($f->getPathName());
			}
		}
	}
	
}