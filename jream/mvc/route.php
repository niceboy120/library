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

/**
 * Class for rerouting uri's.
 */
class Route
{

	/**
	 * @var array $_routes Internal listing
	 */
	private $_routes = array();

	/**
	 * __construct - 
	 * 
	 * @param array $array Pass in:
	 *		array('fake_url_to_find', 'real_url_to_load');
	 */
	public function __construct($array)
	{
		$this->_routes = $array;
	}
		
	/**
	 * Search for a URI match
	 * 
	 * key:		/sample/dog/*
	 * value:	/sample/*
	 * 
	 * @param string $uri 
	 */
	public function match($uri)
	{
		/**
		 * Exit out of here when there are no routes set
		 */
		if (empty($this->_routes)) {
			return false;
		}
		
		/**
		 * Otherwise, Loop through the set
		 */
		foreach ($this->_routes as $findMe => $replaceWith) 
		{
			/**
			 * Use # instead of / due to URI's 
			 */
			preg_match("#^$findMe#", $uri, $match);
			
			/**
			 * If there is a match, setup the actual controller to load 
			 */
			if (!empty($match))
			{		
				/**
				 * Build out the URI without the asterisk 
				 */
				$segment1 = substr($replaceWith, 0, strpos($replaceWith, '*'));
				$segment1 = rtrim($segment1, '/') . '/';
				$segment2 = substr($uri, strlen($match[0]));

				return $segment1 . $segment2;
				
			}
		}
		
		return false;
	}
	

}