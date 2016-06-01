<?php

namespace UserControlSkeleton;

class Requests
{
	public $data;

	public function __construct()
	{
		$this->data = $_POST;
	}
}
