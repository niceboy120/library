<?php

class Index extends jream\MVC\Controller
{

	public function __construct()
	{
		echo __CLASS__ . ' Constructed' . "\n"; 
		parent::__construct();
	}
	
	public function index()
	{
		echo __FUNCTION__ . ' Called' . "\n";
	}
	
	public function argtest($arg1, $arg2)
	{
		echo __CLASS__ . "->" . __FUNCTION__ . " - " . $arg1 . "\n";
		echo __CLASS__ . "->" . __FUNCTION__ . " - " . $arg2 . "\n";
	}

	public function modeltest()
	{
		$this->model->test();
	}
	
	public function viewtest()
	{
		// not ready yet..
	}
}