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
namespace jream;
class Form
{

	/** 
	 * @var object $_format The formatting object. Only instantiated if the method is called.
	 */
	private $_format = false;
	
	/** 
	 * @var object $_validate The validation object. Only instantiated if the method is called.
	 */
	private $_validate = false;
	
	/** 
	 * @var object $_file The file object. Only instantiated if the method is called.
	 */
	private $_file = false;
	
	/**
	 * @var string $_fileField If a file is uploaded this is stored as a reference to create a record inside formName inside the submit() method
	 */
	private $_fileField;
		
	/** 
	 * @var array $_formData Holds the POSTED data inside the object for post-processing 
	 */
	private $_formData = array();
	
	/** 
	 * @var array $_errorData Holds the VALIDATION errors 
	 */
	private $_errorData = array();
	
	/** 
	 * @var string $_currentRecord Holds the immediate record being handled (To chain validation on the spot) 
	 */
	private $_currentRecord = null;
	
	/**
	 * @var mixed $_mimicPost Used for passing artificial $_POST requests
	 */
	private $_mimicPost = null;
	
	/**
	 * __construct - Instanatiates the Validate object 
	 *
	 * @param mixed $mimicPost (Optional) Pass an associative array matching the form->post() names to mimic a POST
	 */
	public function __construct($mimicPost = null)
	{		
		$this->_mimicPost = $mimicPost;
	}
	
	/**
	 * post - Retrieves $_POST data and saves it to the object 
	 *
	 * @param string $name The name of the field to post
	 * @param string $required (Default = false) When set to true && the value is NULL: Unset the value internally and do validate.
	 */
	public function post($name, $required = false)
	{
		/** 
		 * Sanitize the post data (Only allow ASCII up to 127 for now) 
		 */
		if (is_array($this->_mimicPost) && isset($this->_mimicPost[$name]))
		{
			if (isset($this->_mimicPost[$name]))
			$input = $this->_mimicPost[$name];
			
			/** Note: Using jream Exception (Within jream namespace) */
			else
			throw new \jream\Exception('Passing a mimic value that does not match in your Form posts'); 
		}
		else
		{
			$input = isset($_POST[$name]) ? $_POST[$name] : null;
		}
		
		/** 
		 * 	The Sanitize below causes problem when trying to post HTML, so comment it out :)
		 *	$input = filter_var($input, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH);
		 */

		/**
		 * If this is not required, we skip it when the value is null
		 * This is so something can post and someone can EDIT on a few fields at a time
		 */
		if ($required == false && $input == null)
		{
			/** An internal flag to prevent the validator from running */
			$this->_currentRecord = null;
			return $this;
		}

		/**
		 * If the field is required and empty
		 * Mark the error field is required 
		 */
		if ($required == true && $input == null)
		{
			$this->_errorData[$name] = 'is required';
		}
		
		/**
		 * Set a new record in this object 
		 */
		$this->_formData[$name] = $input;
		
		/** 
		 * Hold on to the immediate record incase validation is called next 
		 */
		$this->_currentRecord['key'] = &$name;
		$this->_currentRecord['value'] = &$this->_formData[$name];
				
		return $this;
	}
	
	/**
	* request - Handles the $_REQUEST data
	*/
	public function request($name, $required = false)
	{
		throw new \jream\Exception('This feature is not built yet.');
	}
	
	/**
	 * set - Set an internal record manually
	 * 
	 * @param string $name
	 * @param string $value
	 * @return boolean
	 */
	public function set($name, $value)
	{
		/** I want this to override stuff */
		$this->_formData[$name] = $value;
			
		/** 
		 * Hold on to the immediate record incase validation is called next 
		 */
		$this->_currentRecord['key'] = &$name;
		$this->_currentRecord['value'] = &$value;
		
		return $this;
	}
	
	/**
	* format - Format the POSTED contents internally
	* 
	* @param string $type The name of a function such as md5, trim, etc
	* @param mixed $param Additional parameters for formatting 
	*/
	public function format($type, $param = null)
	{
		/** Instantiate the format class only if it's used */
		if ($this->_format == false)
		$this->_format = new Form\Format();
		
		$key = $this->_currentRecord['key'];
		
		if ($param == null) 
		$this->_formData[$key] = $this->_format->{$type}($this->_currentRecord['value']);
		
		else
		$this->_formData[$key] = $this->_format->{$type}($this->_currentRecord['value'], $param);	
			
		return $this;
	}
	
	/**
	 * validate - Validates the current POST item
	 * 
	 * @param string $action
	 * @param array $param If validating length, do .. ->validate('length', array(1, 4));
	 * @param mixed $option If validating matchany lowercase, do .. ->validate('matchany', array('Jesse', 'Joe'), false);
	 */
	public function validate($action, $param = array(), $option = null)
	{
		/**
		 * From the "post() method" if this is null then then this is not required.
		 */
		if ($this->_currentRecord == null) 
		return $this;
		
		/** Instantiate the validate class only if it's used */
		if ($this->_validate == false) 
		$this->_validate = new Form\Validate();
				
		$key = $this->_currentRecord['key'];
		$value = $this->_currentRecord['value'];
		
		/** Make sure the option absolutely is null to skip an option */
		if ($option === null)
		{	
			$validateStatus = $this->_validate->{$action}($value, $param);
		}
		else
		{
			$validateStatus = $this->_validate->{$action}($value, $param, $option);
		}
		
		if ($validateStatus == true)
		$this->_errorData[$key] = $validateStatus;
		
		return $this;
	}
	
	/**
	 * file - Uploads a file (Do not call validate, format, or error after this)
	 * 
	 * @param string $name The name of the field you are saving
	 * @param string $directory The directory location
	 * @param boolean $required (Default: false) Is this field required?
	 * @param string $saveAs (Default: false) The name to save the file path, include the extension. (false uses the original file name)
	 * @param boolean $overwrite (Default: true) Overwrite the file if it exists? 
	 * 
	 * @return object
	 */
	public function file($name, $directory, $required = false, $saveAs = false, $overwrite = true)
	{
		/** Instantiate the file class only if it's used */
		if ($this->_file == false)
		$this->_file = new Form\File();
				
		/** Store the filename so we can set it in the submit method */
		$this->_fileField = $name;
		
		try {
			
			if ($required == true && empty($_FILES))
			{
				throw new \jream\Exception('is required');
			}
			else
			{
				/** 
				 * This does not upload the file yet, it checks for errors
				 * upload happens if there are no standard form errors on submit() 
				 */
				$this->_file->uploadPrepare($name, $directory, $saveAs, $overwrite); // Exception
			}
			
		} catch(\jream\Exception $e) {
			/** The $name is unique within a form, so an error can be set here with no worries */
			$this->_errorData[$name] = $e->getMessage();
		}
		
		return $this;		
	}
	
	/**
	 * error - Set a custom error message immediately after calling validate()
	 *
	 * @param string $msg The text to display if an error fires
	 *
	 * @return object
	 */
	public function error($msg)
	{
		$key = $this->_currentRecord['key'];
		if (isset($this->_errorData[$key]))
		{
			$this->_errorData[$key] = $msg;
		}
		
		return $this;

	}
	

	/**
	* setError - Set a custom error message for any field at anytime
	* This will prevent me from throwing an exception and not having the other errors.
	* 
	* @param string $name Name of the field
	* @param string $msg Error Message
	* 
	* @return object
	*/
	public function setError($name, $msg)
	{
		$this->_errorData[$name] = $msg;
		return $this;
	}
    
	/**
	 * submit - Processes the entire form and gather errors if any exist
	 *
	 * @param boolean $preserveTemp Keep the previous post data inside a Session 
	 *
	 * @return mixed False for no errors, True (With data) for errors.
	 */
	public function submit($preserveTemp = false)
	{
		/** Preserve form data before we kill it */
		if ($preserveTemp && isset($_SESSION['form']['tmp'])) 
		{
			/** Remove the Previous set */
			unset($_SESSION['form']['tmp']);
			
			/** Update the new set */
			$_SESSION['form']['tmp'] = $this->get();
		}

		if (count($this->_errorData) == 0)
		{
			if ($this->_file != false) 
			{
				/** If the file is at this point, it had no problems with the requirement standards or any other errors */
				$filename = $this->_file->uploadSave();
				$this->_formData[$this->_fileField] = $filename;
			}
			
			return false;
		}
		else
		{
			$output = '';
			foreach($this->_errorData as $key => $value)
			{
				$output .= "$key: $value\n";
			}
			$output = rtrim($output, "\n");
			
			/** Note: Using jream Exception (Within jream namespace) */
			/** Throw our custom Form Exception for outputting a string or array */
			throw new \jream\Exception($output, $this->_errorData);
		}
	}
	
	/**
	 * get - Get a value from the POSTED records stored internally
	 * 
	 * @param string $key (Optional) Returns a specific value
	 * @return mixed Either a string or all items
	 */
	public function get($key = null)
	{
		if ($key != null)
		{
			if (isset($this->_formData[$key]))
			return $this->_formData[$key];	

			else
			return false;			
		}
		
		else
		/**
		* Make sure no empty items get placed
		*/
		return array_filter($this->_formData, 'strlen');
	}
	
	/**
	 * remove - Remove an internal record
	 * 
	 * @param string(s) Pass as many function arguments as needed to unset
	 *		  eg: form->remove('field', 'field2', 'field3');
	 *
	 * @return object
	 */
	public function remove($unlimited) // 
	{
		foreach (func_get_args() as $key => $value) {
			if (isset($this->_formData[$value]))
			unset($this->_formData[$value]);
		}		
		
		return $this;
	}

}