<?php

namespace App\Services\Admin;

use App\Abstracts\Admin\MainAbstract;

class MainService
{
    private MainAbstract $mainAbstract;

    public function __construct(
        MainAbstract $mainAbstract
    )
    {
        $this->mainAbstract = $mainAbstract;
    }

    /**
     * @func topBannersList
     * @description '메인 상단 배너 리스트'
     * @param array $params
     * @return array
     */
    public function topBannersList(array $params): array
    {
        return $this->mainAbstract->topBannersList($params);
    }

    /**
     * @func topBannerCreate
     * @description '메인 상단 배너 등록'
     * @param array $params
     * @return array
     */
    public function topBannerCreate(array $params): array
    {
        return $this->mainAbstract->topBannerCreate($params);
    }
}
