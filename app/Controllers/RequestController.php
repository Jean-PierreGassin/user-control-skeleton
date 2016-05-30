<?php

namespace UserControlSkeleton\Controllers;

class RequestController
{
	public $data;

	public function __construct()
	{
		$this->data = $_POST;
	}
}
