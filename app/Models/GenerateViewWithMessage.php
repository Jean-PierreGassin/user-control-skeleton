<?php

namespace UserControlSkeleton\Models;

class GenerateViewWithMessage
{
	protected $view;

	protected $message;

	public function render($view, $message)
	{
		switch($view) {
			case('/Account'):
			$this->view = '../app/Views/Pages/Account.php';
			$this->message = $message;

			return $this;

			case('UserTable'):
			$this->view = '../app/Views/Admin/UserTable.php';
			$this->message = $message;

			return $this;

			case('error'):
			$_SESSION['error'] = $message;

			return;

			case('success'):
			$_SESSION['success'] = $message;

			return;
		}
	}

	public function now()
	{
		$message = $this->message;

		include_once '../app/Views/Header.php';
		include_once $this->view;
		include_once '../app/Views/Footer.php';
	}
}
