<?php

namespace App\Abstracts;

abstract class MainAbstract
{
    /**
     * @func getMainList
     * @description '메인 페이지 데이터 반환'
     */
    abstract function getMainList(): array;
}
