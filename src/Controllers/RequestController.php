<?php

namespace UserControlSkeleton\Controllers;

class RequestController
{
	public $data;

	protected $keys;

	public function __construct()
	{
		$this->data = $_POST;
	}
}
