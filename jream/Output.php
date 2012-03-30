<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 */
namespace jream;
class Output {
	
	/**
	 * success - Standard JSON Output (success, errorMessage, data)
	 * 
	 * @param string $data Content to encode
	 */
	public static function success($data)
	{
		header('Content-type: application/json');
		echo json_encode(array('success' => 1, 'errorMessage' => null, 'data' => $data));
	}
	
	/**
	 * error - Standard JSON Output (success, errorMessage, data)
	 * 
	 * @param string $errorMessage 
	 */
	public function error($errorMessage)
	{
		header('Content-type: application/json');
		echo json_encode(array('success' => 0, 'errorMessage' => $errorMessage, 'data' => null));
	}
	

}