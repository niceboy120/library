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
class Form
{

	/** 
	 * @var object $_format The formatting object
	 */
	private $_format;
	
	/** 
	 * @var object $_validate The validation object
	 */
	private $_validate;

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
	 * __construct - Instanatiates the Validate object 
	 */
	public function __construct() 
	{
		$this->_format = new Form\Format();
		$this->_validate = new Form\Validate();
	}
	
	/**
	 * post - Retrieves POST data and saves it to the object 
	 * @TODO: CHANGE REQUEST TO POST LATER
	 *
	 * @param string $name The name of the field to post
	 * @param string $required (Default = false) When set to true && the value is NULL: Unset the value internally and do validate.
	 */
	public function post($name, $required = false)
	{
		/** 
		 * Sanitize the post data (Only allow ASCII up to 127 for now) 
		 */
		$input = isset($_REQUEST[$name]) ? trim($_REQUEST[$name]) : null;
		$input = filter_var($input, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH);

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
		
		return $this;
	}
	
	/**
	* format - Format the POSTED contents internally
	* 
	* @param string $type The name of a function such as md5, trim, etc
	*/
	public function format($type)
	{
		$this->_formData[$name] = $this->_format->call($type, $this->_formatData[$name]);
		return $this;
	}
	
	/**
	 * validate - Validates the current POST item
	 * 
	 * @param string $action
	 * @param array $param If validating length, do .. ->validate('length', array(1, 4));
	 */
	public function validate($action, $param = array())
	{
		/**
		 * From the "post() method" if this is null then then this is not required.
		 */
		if ($this->_currentRecord == null) 
		{
			return $this;
		}
		
		$key = $this->_currentRecord['key'];
		$value = $this->_currentRecord['value'];
		
		$validateStatus = $this->_validate->{$action}($value, $param);
		
		if ($validateStatus == true)
		$this->_errorData[$key] = $validateStatus;
		
		return $this;
	}
	
	/**
	 * val - Validates OR formats the current post item;
	 * 
	 * @param string $action
	 * @param array $param If validating length, do .. ->val('length', array(1, 4));
	 */
	public function val($action, $param = array())
	{
		if (!is_array($param)) {
			throw new Exception('Your value has to be an array.');
		}
		
		/**
		 * From the post() method if this is null then then this is not required.
		 */
		if ($this->_currentRecord == null) 
		{
			return $this;
		}
		
		/** The internal record data */
		$key	= $this->_currentRecord['key'];
		$value	= $this->_currentRecord['value'];
	
		
		/** Total parameters passed */
		$paramCount = count($param);
		
		switch($action) {
			
			/**
			 * Validators 
			 */
			case 'match':
				if ($value !== $param[0]) {
					$this->_errorData[$key] = "does not match";
				}
				
				break;
					
			case 'len':
			case 'length':
				$len = strlen($value);
				
				if ($len < $param[0] || $len > $param[1]) {
					$this->_errorData[$key] = "must be between $param[0] and $param[1] characters.";
				}	
				break;

			case 'number':
			case 'digit':
				if (!is_numeric($value)) {
					$this->_errorData[$key] = 'must be numeric.';
				}
				break;
			
			case 'letter':
			case 'alpha':
				if (!ctype_alpha($value)) {
					$this->_errorData[$key] = 'must be A-Z only.';
				}
				break;
				
			case 'email':
				if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
					$this->_errorData[$key] = 'invalid email format.';
				}
		
		return $this;
		}
	}
	
	/**
	 * submit - Processes the entire form and gather errors if any exist
	 * 
	 * @return mixed False for no errors, True (With data) for errors.
	 */
	public function submit()
	{
		if (count($this->_errorData) == 0)
		{
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
			
			throw new \Exception($output);
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
		if (isset($this->_formData[$key]))
		return $this->_formData[$key];
		
		else
		return $this->_formData;
	}
	
	/**
	 * remove - Remove an internal record
	 * 
	 * @param string $key The internal key :)
	 * @return boolean 
	 */
	public function remove($key)
	{
		if (isset($this->_formData[$key]))
		{
			unset($this->_formData[$key]);
		}
		
		return $this;
	}
	
	/**
	 * dump - Debug & See what is inside the object quickly
	 */
	public function dump()
	{
		echo '<pre>';
		print_r($this->_formData);
		print_r($this->_errorData);
		echo '</pre>';
	}
}