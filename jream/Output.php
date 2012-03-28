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