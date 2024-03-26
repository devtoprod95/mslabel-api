<?php

namespace App\Constants;

class SubTitleConstant
{
    // 메인 페이지 02 영역
    public const MAIN_02_BUSINESS = "main_02_business";
    public const MAIN_02_QUALITY  = "main_02_quality";
    public const MAIN_02_FORM     = "main_02_form";
    public const MAIN_02_MACHINE  = "main_02_machine";

    public const MAIN_02_LIST = [
        self::MAIN_02_BUSINESS,
        self::MAIN_02_QUALITY,
        self::MAIN_02_FORM,
        self::MAIN_02_MACHINE,
    ];

    public const MAIN_02_LIST_KO = [
        self::MAIN_02_BUSINESS => "업종별",
        self::MAIN_02_QUALITY  => "재질별",
        self::MAIN_02_FORM     => "형태별",
        self::MAIN_02_MACHINE  => "기계별",
    ];

    // 메인 페이지 03 영역
    public const MAIN_03_PRODUCT    = "main_03_product";
    public const MAIN_03_PROMOTION  = "main_03_promotion";
    public const MAIN_03_DECORATING = "main_03_decorating";
    public const MAIN_03_POUCH      = "main_03_pouch";

    public const MAIN_03_LIST = [
        self::MAIN_03_PRODUCT,
        self::MAIN_03_PROMOTION,
        self::MAIN_03_DECORATING,
        self::MAIN_03_POUCH,
    ];
}
