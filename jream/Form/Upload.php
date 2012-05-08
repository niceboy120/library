<?php
/**
*	Copyright (C) 2011 JREAM Design. All Rights Reserved.
*
*	@copyright		Copyright 2011, JREAM
*	@author			Jesse Boyer <contact@jream.com>
*	@link			http://jream.com
*/
namespace jream\Form;
class Upload
{

	private $_name;
	private $_field;
	private $_dir;
	private $_newFileName;
	private $_overwrite = true;
	
	/**
	* field - Gets the name of the file field
	* @param string $field The name of the file field in the HTML
	*/
	public function field($field)
	{		
		$this->_field = $field;
	}
	
	/**
	* fileName - Assign a different name to the file other than what was uploaded
	* @param string $name The new name of the file
	*/
	public function fileName($name)
	{
		$this->_newFileName = $name;
	}
	
	/**
	* overwrite - Toggles overwriting of files, default is ON
	* @param boolean $overwrite Do you want to overwrite a duplicate file?
	*/
	public function overwrite($overwrite)
	{
		/** Do we want to overwrite files? */
		$this->_overwrite = (boolean) $overwrite;
	}
	
	/**
	* dir - Optionally move the file to another directory after its uploaded
	* @param string $dir The path to store the file
	*/
	public function dir($dir)
	{
		if (isset($dir))
		{
			if (substr($dir, -1) != '/')
			$dir .= '/';
		}
		$this->_dir = $dir;
	}
	
	/**
	* maxSize - Limits the max size
	* @param integer $bytes The size in bytes
	*/
	public function maxSize($bytes)
	{
		$this->_maxSize = (int) $bytes;
	}

	/**
	 * submit - Attempts to move the file into the user specific directory.
	 *		 If anything goes wrong PHP will issue a warning.
	 */
	public function submit()
	{
		/** Grab the File name and extension */
		$this->_name = $_FILES[$this->_field]['name'];
		$this->_ext = substr($this->_name, strrpos($this->_name, '.') + 1);
		
		$this->_fileErrors();
		/** If overwrite is off and the file exists */
		
		if (isset($this->_newFileName))
		{
			if ($this->_overwrite == false && file_exists($this->_dir . $this->_newFileName . '.' . $this->_ext))
			{
				throw new \jream\Exception("This file already exists, please use another name.");
			}
			else 
			{
				if (move_uploaded_file($_FILES[$this->_field]["tmp_name"], $this->_dir . $this->_newFileName . '.' . $this->_ext) == true)
				@chmod($this->_dir . $this->_name, 0777);

				else 
				throw new \jream\Exception('Problem uploading');
			}		
		}
		else
		{
			if ($this->_overwrite == false && file_exists($this->_dir . $this->_name))
			{
				throw new \jream\Exception("This file already exists, please use another name.");
			}
			else 
			{
				if (move_uploaded_file($_FILES[$this->_field]["tmp_name"], $this->_dir . $this->_name) == true)
				@chmod($this->_dir . $this->_name, 0777);

				else 
				throw new \jream\Exception('Problem uploading');
			}
		}
	}

	/**
	 * _fileErrors Checks the incoming file for errors and whether it exists or not.
	 * @return mixed String or Boolean: Return the warning, otherwise return false.
	 */
	private function _fileErrors()
	{
		if ($_FILES[$this->_field]['size'] > $this->_maxSize) {
			throw new \jream\Exception("The maximum file size is {$this->_maxSize}, yours is too large");
		}

		switch ($_FILES[$this->_field]['error'])
		{

			case 1:
				throw new \jream\Exception('INI_SIZE; The uploaded file exceeds the upload_max_filesize directive in php.ini.');
				break;

			case 2:
				throw new \jream\Exception('FORM_SIZE; The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.');
				break;

			case 3:
				throw new \jream\Exception('PARTIAL; The uploaded file was only partially uploaded.');
				break;

			case 4:
				throw new \jream\Exception('NO_FILE; No file was uploaded.');
				break;

			case 6:
				throw new \jream\Exception('NO_TMP_dir; Missing a temporary folder.');
				break;

			case 7:
				throw new \jream\Exception('CANT_WRITE; Failed to write file to disk.');
				break;

			case 8:
				throw new \jream\Exception('EXTENSION; A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.');
				break;

			default:
				return false;
				break;
		}

	}
	
	/**
	 * get - Returns the array of the new file
	 * @return array 
	 */
	public function get()
	{
	    return array(
			'dir' => $this->_dir,
			'name' => isset($this->_newFileName) ? $this->_newFileName : $this->_name
	    );

	}

}