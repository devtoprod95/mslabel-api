<?php

namespace App\Abstracts\Admin;

abstract class MenuAbstract
{
    /**
     * @func mainList
     * @description '메인 메뉴 게시판 리스트'
     * @return array
     */
    abstract function mainList(): array;

    /**
     * @func mainEdit
     * @description '대표 메뉴 수정'
     * @param array $params
     * @return array
     */
    abstract function mainEdit(array $params): array;

    /**
     * @func subList
     * @description '서브 메뉴 리스트'
     * @param array $params
     * @return array
     */
    abstract function subList(array $params): array;

    /**
     * @func subMenuCreate
     * @description '서브 메뉴 추가'
     * @param array $params
     * @return array
     */
    abstract function subMenuCreate(array $params): array;

    /**
     * @func subEdit
     * @description '서브 메뉴 수정'
     * @param array $params
     * @return array
     */
    abstract function subEdit(array $params): array;

    /**
     * @func subDelete
     * @description '서브 메뉴 삭제'
     * @param int $id
     * @return array
     */
    abstract function subDelete(int $id): array;
}
