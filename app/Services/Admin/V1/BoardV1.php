<?php

namespace App\Services\Admin\V1;

use App\Abstracts\Admin\BoardAbstract;

class BoardV1 extends BoardAbstract
{
    protected array $returnMsg;

    public function __construct()
    {
        $this->returnMsg = helpers_fail_message();
    }
}
