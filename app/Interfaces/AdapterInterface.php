<?php

namespace UserControlSkeleton\Interfaces;

interface AdapterInterface
{
    public function connect();

    public function getColumns();
}
