<?php

class Index_Model extends jream\MVC\Model
{

	public function __construct()
	{
		echo __CLASS__ . ' Constructed' . "\n"; 
		parent::__construct();
	}
	
	public function test()
	{
		echo __CLASS__ . ' ' . __FUNCTION__ . "\n";
	}

}