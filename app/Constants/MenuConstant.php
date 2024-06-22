<?php

namespace App\Constants;

class MenuConstant
{
    /** 서브 메뉴 유형 */
    public const SUB_TYPE_IMAGE   = "image";
    public const SUB_TYPE_PRODUCT = "product";
    public const SUB_TYPE_BOARD   = "board";
    public const SUB_TYPE_EDITOR  = "editor";
    public const SUB_TYPE_LIST = [
        self::SUB_TYPE_IMAGE,
        self::SUB_TYPE_PRODUCT,
        self::SUB_TYPE_BOARD,
        self::SUB_TYPE_EDITOR,
    ];
    public const SUB_TYPE_TEXT = [
        self::SUB_TYPE_IMAGE   => "이미지",
        self::SUB_TYPE_PRODUCT => "상품",
        self::SUB_TYPE_BOARD   => "게시판",
        self::SUB_TYPE_EDITOR  => "에디터",
    ];
}
