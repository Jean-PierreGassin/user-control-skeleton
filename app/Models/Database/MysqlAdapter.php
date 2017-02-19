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

    public function select($columns, $table, $where = false, $operator = false, $value = false, $multiple = false)
    {
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }

        $queryString = "SELECT $columns FROM $table";

        if ($where && $operator && $value) {
            $queryString .= " WHERE $where $operator ?";
        }

        $statement = $this->connect();
        $statement = $statement->prepare($queryString);

        if ($value) {
            $statement->execute([$value]);
        } else {
            $statement->execute();
        }

        if ($multiple) {
            $results = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $row;
            }

            return $results;
        }

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($table, $columns)
    {
        $queryString = "INSERT INTO $table";

        foreach ($columns as $key => $value) {
            $columnNames[] = $key;

            if (count($columnNames) > 1) {
                $queryString .= ", $key";

                continue;
            }

            $queryString .= " ($key";
        }

        $queryString .= ")";

        foreach ($columns as $key => $value) {
            $columnValues[] = $value;

            if (count($columnValues) > 1) {
                $queryString .= ", ?";

                continue;
            }

            $queryString .= " VALUES (?";
        }

        $queryString .= ")";

        $statement = $this->connect();
        $statement = $statement->prepare($queryString);

        $statement->execute($columnValues);
    }

    public function update($table, $columns, $where = false, $operator = false, $value = false)
    {
        $bindings = [];

        $queryString = "UPDATE $table";

        foreach ($columns as $key => $value) {
            $bindings[] = $value;

            if (count($bindings) > 1) {
                $queryString .= ", $key = ?";

                continue;
            }

            $queryString .= " SET $key = ?";
        }

        if ($where && $operator && $value) {
            $queryString .= " WHERE $where $operator ?";
            $bindings[] = $value;
        }

        $statement = $this->connect();
        $statement = $statement->prepare($queryString);

        $statement->execute($bindings);
    }
}
