// addBody($html)
// addHeaders([])
// setStatus(int)
<?php

class Response
{
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function addHeaders($header)
    {
        $this->header = $header;

        return $this;
    }
}
