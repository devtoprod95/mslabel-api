<?php

namespace App\Constants;

class BoardErrorMessageConstant
{
    private static $defaultMsg         = "(을)를 입력해주세요.";
    private static $defaultTypeMsg     = "의 타입형식이 올바르지 않습니다.";
    private static $defaultHaveMsg     = "(은)는 이미 등록되어 있습니다.";
    private static $defaultNotHaveMsg  = "Empty";
    private static $defaultFitErrorMsg = "Error";

    public const ERROR_MESSAGE_GROUP_ID    = "메인 메뉴 id";
    public const ERROR_MESSAGE_SUB_ID      = "서브 메뉴 id";
    public const ERROR_MESSAGE_TITLE       = "제목";
    public const ERROR_MESSAGE_IS_SHOW     = "노출여부";
    public const ERROR_MESSAGE_DESC        = "내용";
    public const ERROR_MESSAGE_MAIN_IMG    = "메인 이미지";
    public const ERROR_MESSAGE_BOTTOM_IMG1 = "하단 이미지1";
    public const ERROR_MESSAGE_MATERIAL    = "원단";
    public const ERROR_MESSAGE_SIZE        = "사이즈";
    public const ERROR_MESSAGE_SHAPE       = "형태";
    public const ERROR_MESSAGE_KEYWORDS    = "키워드";
   
    public static function getErrorMessageNotDefault($constantName): string
    {
        $errorMessage = constant('self::ERROR_MESSAGE_' . $constantName);
        return $errorMessage;
    }

    public static function getErrorMessage($constantName): string
    {
        $errorMessage = constant('self::ERROR_MESSAGE_' . $constantName);
        return $errorMessage . self::$defaultMsg;
    }

    public static function getTypeErrorMessage($constantName): string
    {
        $errorMessage = constant('self::ERROR_MESSAGE_' . $constantName);
        return $errorMessage . self::$defaultTypeMsg;
    }

    public static function getHaveErrorMessage(string $constantName): string
    {
        $errorMessage = constant('self::ERROR_MESSAGE_' . $constantName);
        return $errorMessage . self::$defaultHaveMsg;
    }

    public static function getNotHaveErrorMessage(string $constantName): string
    {
        $errorMessage = constant('self::ERROR_MESSAGE_' . $constantName);
        return self::$defaultNotHaveMsg . " " . $errorMessage;
    }

    public static function getFitErrorMessage(string $constantName): string
    {
        $errorMessage = constant('self::ERROR_MESSAGE_' . $constantName);
        return self::$defaultFitErrorMsg . " " . $errorMessage;
    }
}
