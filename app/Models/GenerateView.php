<?php

namespace UserControlSkeleton\Models;

class GenerateView
{
	protected $view;

	public function render($view)
	{
		switch($view) {
			case('/'):
			$this->view = [
				'../app/Views/Header.php',
				'../app/Views/Pages/Home.php',
				'../app/Views/Footer.php'
			];

			return $this;

			case('/UserNavBar'):
			$this->view = [
				'../app/Views/Header.php',
				'../app/Views/Navigation/UserNavBar.php',
				'../app/Views/Footer.php'
			];

			return $this;

			case('/GuestNavBar'):
			$this->view = [
				'../app/Views/Header.php',
				'../app/Views/Navigation/GuestNavBar.php',
				'../app/Views/Footer.php'
			];

			return $this;

			case('/AdminNavBar'):
			$this->view = [
				'../app/Views/Header.php',
				'../app/Views/Navigation/AdminNavBar.php',
				'../app/Views/Footer.php'
			];

			return $this;

			case('/Register'):
			$this->view = [
				'../app/Views/Header.php',
				'../app/Views/Pages/Register.php',
				'../app/Views/Footer.php'
			];

			return $this;

			case('/controlPanel'):
			$this->view = [
				'../app/Views/Header.php',
				'../app/Views/Pages/ControlPanel.php',
				'../app/Views/Footer.php'
			];

			return $this;

			default:
			$this->view = [
				'../app/Views/Header.php',
				'../app/Views/Pages/Home.php',
				'../app/Views/Footer.php'
			];

			return $this;
		}
	}

	public function now()
	{
		foreach ($this->view as $view) {
			include_once $view;
		}
	}
}
