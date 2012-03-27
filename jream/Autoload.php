<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (c), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 * @link		http://jream.com
 *
 * This program is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details:
 * http://www.gnu.org/licenses/
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
		$this->_dir = $dir;
		
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
		
		$sections = array();

		foreach(glob($this->_dir . '*') as $file)  
		{

			/** Prevent this file from being loaded */
			if ($file == $this->_dir . 'Autoload.php')
			continue;
			
			if (!is_dir($file))
			array_push($sections, $file);
			else
			{
				foreach(glob($file . '/*') as $subfile)
				{
					if (!is_dir($subfile))
					array_push($sections, $subfile);
				}
			}
		}

		/** Iterate: Require each Object */
		foreach ($sections as $dir)
		{
			require $dir;
		}
		
		$this->_loadCalled = true;
	}
}