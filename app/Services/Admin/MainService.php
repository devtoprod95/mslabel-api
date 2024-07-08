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

    /**
     * @func topBannerEdit
     * @description '메인 상단 배너 수정'
     * @param int $id
     * @param array $params
     * @return array
     */
    public function topBannerEdit(int $id, array $params): array
    {
        return $this->mainAbstract->topBannerEdit($id, $params);
    }

    /**
     * @func topBannerDelete
     * @description '메인 상단 배너 삭제'
     * @param int $id
     * @return array
     */
    public function topBannerDelete(int $id): array
    {
        return $this->mainAbstract->topBannerDelete($id);
    }

    /**
     * @func introList
     * @description '메인 소개 리스트'
     * @param array $params
     * @return array
     */
    public function introList(array $params): array
    {
        return $this->mainAbstract->introList($params);
    }

    /**
     * @func introCreate
     * @description '메인 소개 등록'
     * @param array $params
     * @return array
     */
    public function introCreate(array $params): array
    {
        return $this->mainAbstract->introCreate($params);
    }

    /**
     * @func introEdit
     * @description '메인 소개 수정'
     * @param int $id
     * @param array $params
     * @return array
     */
    public function introEdit(int $id, array $params): array
    {
        return $this->mainAbstract->introEdit($id, $params);
    }

    /**
     * @func introDelete
     * @description '메인 소개 삭제'
     * @param int $id
     * @return array
     */
    public function introDelete(int $id): array
    {
        return $this->mainAbstract->introDelete($id);
    }

    /**
     * @func intro2List
     * @description '메인 소개2 리스트'
     * @param array $params
     * @return array
     */
    public function intro2List(array $params): array
    {
        return $this->mainAbstract->intro2List($params);
    }

    /**
     * @func intro2Create
     * @description '메인 소개2 등록'
     * @param array $params
     * @return array
     */
    public function intro2Create(array $params): array
    {
        return $this->mainAbstract->intro2Create($params);
    }

    /**
     * @func intro2Edit
     * @description '메인 소개2 수정'
     * @param int $id
     * @param array $params
     * @return array
     */
    public function intro2Edit(int $id, array $params): array
    {
        return $this->mainAbstract->intro2Edit($id, $params);
    }

    /**
     * @func intro2Delete
     * @description '메인 소개2 삭제'
     * @param int $id
     * @return array
     */
    public function intro2Delete(int $id): array
    {
        return $this->mainAbstract->intro2Delete($id);
    }
}
