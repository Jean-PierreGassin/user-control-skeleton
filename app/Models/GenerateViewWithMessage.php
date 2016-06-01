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
			$this->view = [
				'../app/Views/Header.php',
				'../app/Views/Pages/Account.php',
				'../app/Views/Footer.php'
			];

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
		if (!is_array($this->view)) {
			$message = $this->message;

			include_once $this->view;

			return;
		}

		foreach ($this->view as $view) {
			$message = $this->message;

			include_once $view;
		}
	}
}
