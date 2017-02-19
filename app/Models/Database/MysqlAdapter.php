<?php

namespace UserControlSkeleton\Models\Database;

use PDO;
use UserControlSkeleton\Interfaces\AdapterInterface;

class MysqlAdapter implements AdapterInterface
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
            $link = new PDO(
                $this->driver.':host='.$this->host.';
                port='.$this->port.';
                dbname='.$this->name.';
                charset=UTF8;',
                $this->user,
                $this->pass
            );

            return $link;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function getColumns()
    {
        $databaseName = getenv('DATABASE_NAME');

        $statement = $this->connect();
        $statement = $statement->prepare('
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = "$databaseName"
            AND TABLE_NAME = "users"
        ');

        $statement->execute();
        $statement->fetch(PDO::FETCH_ASSOC);

        return $statement;
    }
}
