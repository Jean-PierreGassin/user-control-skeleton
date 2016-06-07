<?php

namespace UserControlSkeleton;

class Request
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
		if (!array_key_exists($field, $this->data)) {
			return;
		}

		return $this->data[$field];
	}
}
