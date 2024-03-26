<?php

namespace App\Services;

use App\Abstracts\MainAbstract;

class MainService
{
    private MainAbstract $mainAbstract;

    public function __construct(
        MainAbstract $mainAbstract
    )
    {
        $this->mainAbstract = $mainAbstract;
    }

    public function getMainList(): array
    {
        return $this->mainAbstract->getMainList();
    }
}
