<?php
/**
 * @author		Jesse Boyer <contact@jream.com>
 * @copyright	Copyright (C), 2011-12 Jesse Boyer
 * @license		GNU General Public License 3 (http://www.gnu.org/licenses/)
 *				Refer to the LICENSE file distributed within the package.
 *
 * @link		http://jream.com
 * @category	Form
 */
namespace jream\Form;
class File
{

	/** @var string $_name The name of the field to post */
	private $_name;
	
	/** @var string $_name The directory to save to*/
	private $_directory;
	
	/** @var string $_saveAs The name of the file to save as */
	private $_saveAs;
	
	/** @var boolean $_overwrite To overwrite a file if it exists */
	private $_overwrite = true;
		
	/**
	 * uploadPrepare - Prepares a file for upload
	 * 
	 * @param string $name The form name value to post
	 * @param string $directory The directory to save to
	 * @param string $required Is this file required
	 * @param string $saveAs (Default: false) Set a name to save it as a custom name (Extension will be automatically added)
	 * 
	 * @return boolean
	 * 
	 * @throws \jream\Exception 
	 */
	public function uploadPrepare($name, $directory, $saveAs = false, $overwrite = true)
	{
		if (!isset($_FILES) || empty($_FILES)) 
		return false;
		
		/**
		 * Set the class-wide properties 
		 */
		$this->_name = $name;
		$this->_directory = trim($directory, '/') . '/';
		$this->_saveAs = ($saveAs == true) ? $saveAs : $_FILES[$name]['name'];
		$this->_overwrite = $overwrite;

		/**
		 * Make sure the pathSave is a directory
		 */
		if (!is_dir($this->_directory)) 
		throw new \jream\Exception("must be a directory: {$this->_directory}");
		
		/**
		 * Get the octal permission of the directory, eg: 0777
		 * Note: This turns the permission into a (string)
		 */
		$writable = substr(sprintf('%o', fileperms($this->_directory)), -4);
		
		if ($writable != "0777") 
		throw new \jream\Exception("directory is not writable: {$this->_directory}");
		
		if ($_FILES[$this->_name]['error'] != 0)
		throw new \jream\Exception($_FILES[$this->_name]['error']);
  
		if ($overwrite == false && file_exists($this->_directory . $this->_saveAs))
		throw new \jream\Exception("file already exists and cannot be overwritten: {$this->_directory}{$this->_saveAs}");
		
		/**
		 * Handle the naming of the file
		 */		
		if ($this->_saveAs == true)
		{
			/** 
			 * Grab the file extension 
			 * Note: May have problems with tar.gz format
			 */
			$ext = substr(strrchr($_FILES[$this->_name]['name'], '.'), 1);
			$this->_saveAs = "{$this->_saveAs}.$ext";
		}
		else
		{
			/**
			 * Use original filename 
			 */
			$this->_saveAs = $_FILES[$this->_name]['name'];
		}		

	}
	
	/**
	 * uploadSave() - This is to be called from the \Form\submit() method, so it only tries to save when the form is complete
	 * 
	 * @return boolean
	 */
	public function uploadSave()
	{
		if (!isset($_FILES) || empty($_FILES)) 
		return false;

		$result = move_uploaded_file($_FILES[$this->_name]['tmp_name'], $this->_directory . $this->_saveAs);
		return $this->_saveAs;
	}
	
}