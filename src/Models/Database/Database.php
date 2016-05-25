<?php

namespace UserControlSkeleton\Models\Database;

use PDO;

class Database
{
	protected $user;

	protected $pass;

	protected $host;

	protected $port;

	protected $name;

	protected $driver;

	public function __construct()
	{
		$this->user = getenv('DATABASE_USER');
		$this->pass = getenv('DATABASE_PASS');
		$this->host = getenv('DATABASE_HOST');
		$this->port = getenv('DATABASE_PORT');
		$this->name = getenv('DATABASE_NAME');
		$this->driver = getenv('DATABASE_DRIVER');
	}

    public function connect()
    {
        try {
            $link = new PDO($this->driver.':host='.$this->host.';port='.$this->port.';dbname='.$this->name.';charset=UTF8;', $this->user, $this->pass);

            return $link;
        } catch (PDOException $e) {
            GenerateViewWithMessage::renderView('error', $e->getMessage());
        }
    }
}