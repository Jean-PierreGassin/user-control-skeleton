<?php

namespace UserControlSkeleton\Interfaces;

use UserControlSkeleton\Requests;

interface UserInterface
{
	public function __construct();
	public function create(Requests $request, $userGroup);
	public function update(Requests $request);
	public function exists($user);
	public function isAdmin();
	public function getInfo();
	public function getPassword($username);
	public function search($searchTerms);
}
