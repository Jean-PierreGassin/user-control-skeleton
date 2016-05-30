<?php

namespace UserControlSkeleton\Interfaces;

interface DatabaseInterface
{
	public function __construct();
	public function connect();
	public function getColumns();
}
