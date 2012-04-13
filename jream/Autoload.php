<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 * @example
 * require_once '/jream/Autoload.php';
 * new jream\Autoload('/jream/');
 */
namespace jream;
class Autoload
{

	/** @var string $_dir Directory to autoload */
	private $_dir;
	
	/** @var boolean $_loadCalled Flag to prevent the load from processing twice */
	private $_loadCalled;
	
	/**
	* Initializes SPL Autoloader
	*
	* @param string $dir The location of the API directory
	*/
	public function __construct($dir)
	{
		/** Make sure there is always a trailing slash */
		$this->_dir = rtrim($dir, '/').'/';
		
		/** Prevent other autoloaders from collision */
		$beingLoaded = spl_autoload_functions();

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
		
		/** Get the autoload classname without the namespace */
		$classname = explode('\\', __CLASS__);
		$classname = end($classname);

		foreach(glob($this->_dir . '*') as $file)  
		{
			/** Don't load the autoloader class */
			if ($file == $this->_dir . $classname . '.php')
			continue;

			/** Require the needed files  */
			if (!is_dir($file))
			require $file;
			
			else
			{
				foreach(glob($file . '/*') as $subfile)
				{
					/** We are only going one folder deep */
					if (!is_dir($subfile))
					require $subfile;
				}
			}

		}
		
		$this->_loadCalled = true;
	}
}