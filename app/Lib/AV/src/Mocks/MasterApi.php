<?php

namespace AV\Mocks;

use AV\Api\Master;

class MasterApi extends Master {

    private $funcAvailable;

    public function funcAvailable($name = null)
    {
        return $this->funcAvailable !== false;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function setFuncAvailable($bool)
    {
        $this->funcAvailable = $bool;
    }
}
