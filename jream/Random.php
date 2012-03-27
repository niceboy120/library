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
class Random
{

	/**
	 * text - Creates a random string of text based $length
	 * @param integer $intLength Length of the string
	 * @return string The finished random string!
	 */
	public static function text($length = 8)
	{
		$randomString = NULL;

		/* Seed */
    	srand((double) microtime() * 1000000);

		/** Create Characters */
    	for ($i = 0; $i < $length; $i++)
    	{
        	$n = rand(48,120);

        	while (($n >= 58 && $n <= 64) || ($n >= 91 && $n <= 96))
           	$n = rand(48,120);
        	
        	$randomString .= chr($n);
        }
        
    	return $randomString;
	}

	/**
	 * digit - Creates a random digit.
	 * @param integer $length How many placeholders? ie: 100 - 999 is 3
	 * @return integer 
	 */
	public static function digit($length = 8)
	{
		$min = 1;
		$max = 9;

		for ($i = 2; $i <= $length; $i++)
		{
			$min .= 0;
			$max .= 9;
		}

		return rand($min, $max);

	}
	

}