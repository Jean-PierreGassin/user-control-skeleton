<?php

namespace UserControlSkeleton\Models;

class GenerateView
{
	protected $view;

	protected $message;

	public function render($view, $message = null)
	{
		switch($view) {
			case('/'):
			$this->view = '../app/Views/Pages/Home.php';

			return $this;

			case('/UserNavBar'):
			$this->view = '../app/Views/Navigation/UserNavBar.php';

			return $this;

			case('/GuestNavBar'):
			$this->view = '../app/Views/Navigation/GuestNavBar.php';

			return $this;

			case('/AdminNavBar'):
			$this->view = '../app/Views/Navigation/AdminNavBar.php';

			return $this;

			case('/Register'):
			$this->view = '../app/Views/Pages/Register.php';

			return $this;

			case('/controlPanel'):
			$this->view = '../app/Views/Pages/ControlPanel.php';

			return $this;

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

			default:
			$this->view = '../app/Views/Pages/Home.php';

			return $this;
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
