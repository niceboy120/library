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
class Email
{
	/**	Sending Details */
	private $_to;
	private $_from;
	private $_bcc;
	private $_cc;
	private $_subject;
	private $_message;
	private $_contentType;
	
	/**
	* When created the default contentType is set to text/plain
	*/
	public function construct() 
	{
		$this->_contentType = (string) 'text/plain';
	}
	
	/**
	* setTo - Who do you want to deliver this email to?
	* @param string $str The receiver
	*/
	public function setTo($str)
	{
		$this->_to = (string) $str;
		return $this;
	}

	/**
	* setFrom - Who to reply to if this mail is sent?
	* @param string $str The sender
	*/
	public function setFrom($str)
	{
		$this->_from = (string) $str;
		return $this;
	}

	/**
	* setSubject - The subject of the email
	* @param string $str The entire subject
	*/
	public function setSubject($str)
	{
		$this->_subject = (string) $str;
		return $this;
	}
	
	/**
	* setMessage - The body contents of the message being sent
	* @param string $str The entire message
	*/
	public function setMessage($str)
	{
		$this->_message = (string) wordwrap($str, 70);
		return $this;
	}


	/**
	 * setBcc - Optional Bcc
	 * @param string $bcc Use CSV format for BCC
	 */	
	public function setBcc($bcc)
	{
		$this->_bcc = (string) $bcc;
		return $this;
	}

	/**
	 * setCc - Optional Cc
	 * @param string $cc Use CSV format for CC
	 */	
	public function setCc($cc)
	{
		$this->_cc = (string) $cc;
		return $this;
	}
	
	/**
	* setContentType - Set the header encoding
	* @param string $type Could be text/plain(default) or text/html
	*/
	public function setContentType($type)
	{
		$this->_contentType = (string) $type;
		return $this;
	}
	
	/**
	 * submit - Sends the email, by default this is sent in HTML format just because it will revert to text
	 * 		 if the users html feature is disabled.
	 */	
	public function submit()
	{
		$this->_checkSettings();
		$headers =	"From: {$this->_from}\r\n";
		$headers .=	"Reply-To: {$this->_from}\r\n";
		$headers .=	"cc: {$this->_cc}\r\n";
		$headers .=	"Bcc: {$this->_bcc}\r\n";
		$headers .=	"MIME-Version: 1.0\r\n" ;
		$headers .=	"Content-type: {$this->_contentType}; charset=utf-8\r\n" ;
		
		/** Silence the email warning, we are handling this with an exception */		
		if (@!mail($this->_to, $this->_subject, $this->_message, $headers))
		throw new Exception('Problem sending email');
	}
	
	/**
	* _checkSettings - Makes sure all the necessary fields are set to send an email
	*/
	private function _checkSettings()
	{
		if (!isset($this->_to))
		throw new Exception('To must be set');
	
		if (!isset($this->_from))
		throw new Exception('From must be set');

		if (!isset($this->_subject))
		throw new Exception('Subject must be set');		

		if (!isset($this->_message))
		throw new Exception('Message must be set');
	}

}