<?php

namespace UserControlSkeleton;

class Requests
{
	protected $data;

	public function __construct()
	{
		foreach ($_POST as $key => $value) {
			$this->data[$key] = $value;
		}
	}

	public function get($field)
	{
		return $this->data[$field];
	}
}
