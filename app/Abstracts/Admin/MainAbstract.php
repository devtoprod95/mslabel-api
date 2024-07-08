<?php

namespace App\Abstracts\Admin;

abstract class MainAbstract
{
    /**
     * @func topBannersList
     * @description '메인 상단 배너 리스트'
     * @param array $params
     * @return array
     */
    abstract function topBannersList(array $params): array;

    /**
     * @func topBannerCreate
     * @description '메인 상단 배너 등록'
     * @param array $params
     * @return array
     */
    abstract function topBannerCreate(array $params): array;

    /**
     * @func topBannerEdit
     * @description '메인 상단 배너 수정'
     * @param int $id
     * @param array $params
     * @return array
     */
    abstract function topBannerEdit(int $id, array $params): array;

    /**
     * @func topBannerDelete
     * @description '메인 상단 배너 삭제'
     * @param int $id
     * @return array
     */
    abstract function topBannerDelete(int $id): array;
}
