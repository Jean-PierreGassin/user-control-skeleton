<?php

namespace UserControlSkeleton\Controllers;

use UserControlSkeleton\Models\Database\MysqlAdapter;

class DatabaseController
{
    public $adapter;

    public function __construct()
    {
        $adapter = '\UserControlSkeleton\Models\Database\\' . $this->getAdapter();

        $this->adapter = new $adapter;
    }

    public function getAdapter()
    {
        $adapterDriver = getenv('DATABASE_DRIVER');

        if ($adapterDriver === 'mysql') {
            return MysqlAdapter;
        }
    }
}
