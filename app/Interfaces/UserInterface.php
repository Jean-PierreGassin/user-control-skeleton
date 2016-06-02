<?php

namespace UserControlSkeleton\Interfaces;

interface UserInterface
{
	public function __construct();
	public function create($request, $userGroup);
	public function update($username, $password, $firstName, $lastName);
	public function isAdmin();
	public function getInfo();
	public function getPassword($username);
	public function search($searchTerms);
}
