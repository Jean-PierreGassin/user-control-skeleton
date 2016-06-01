<?php

namespace UserControlSkeleton\Models;

class GenerateView
{
	protected $view;

	public function render($view)
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

			default:
			$this->view = '../app/Views/Pages/Home.php';

			return $this;
		}
	}

	public function now()
	{
		include_once '../app/Views/Header.php';
		include_once $this->view;
		include_once '../app/Views/Footer.php';
	}
}
