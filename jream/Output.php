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
	* json - Outputs data in JSON format
	* @param boolean $success Was is successful?
	* @param string $data Either the error message or the data to output
	*/
	public static function json($success, $data = 'There was an error') 
	{
		$success = (boolean) $success;
		
		if ($success == 1) {
			$json = json_encode(array('error' => 0, 'errorMessage' => null, 'data' => $data));
		} elseif ($success == 0) {
			$json = json_encode(array('error' => 1, 'errorMessage' => $data));
		}
		
		header('Content-type: application/json');
		echo $json;
		exit;
	}
	
	/**
	 * error - Outputs an error in an attractive HTML format (For killing a page). Uses systemError style
	 * This should only be used BEFORE any HTML is loaded, it sets up the entire page.
	 * @param string $summary A very short summary of where the problem can be resolved.
	 * @param string $details The details as to why there is a problem.
	 */
	public static function error($summary, $details)
	{	
		$output = "
		<!doctype html>
		<html>
		<head>
			<title>System Error</title>
			<link rel='stylesheet' href='". URL ."public/css/default/reset.css' />
			<link rel='stylesheet' href='". URL ."public/css/default/framework.css' />
			<link rel='stylesheet' href='". URL ."public/css/default/misc.css' />
			<link rel='shortcut icon' href='". URL . "public/images/favicon.png' />
		</head>
		<body>
			<div id='systemErrorWrapper'>
				<div id='systemErrorHeader'>
					<h1>System Error</h1>
				</div>
				<div id='systemErrorContent'>
					
					<div id='systemErrorContentSummary'>$summary</div>
				
					<div id='systemErrorContentDetails'>
						$details
					</div>
				</div>
			</div>
		</body>
		</html>";
		
		echo $output;
		die;
	}

}