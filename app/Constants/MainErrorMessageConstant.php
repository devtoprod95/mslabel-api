<?php

namespace App\Constants;

class MainErrorMessageConstant
{
    private static $defaultMsg         = "(을)를 입력해주세요.";
    private static $defaultTypeMsg     = "의 타입형식이 올바르지 않습니다.";
    private static $defaultHaveMsg     = "(은)는 이미 등록되어 있습니다.";
    private static $defaultNotHaveMsg  = "Empty";
    private static $defaultFitErrorMsg = "Error";

    public const ERROR_MESSAGE_TITLE                  = "title";
    public const ERROR_MESSAGE_IS_ALWAYS_SHOW         = "is_always_show";
    public const ERROR_MESSAGE_SHOW_STARTED_AT        = "show_started_at";
    public const ERROR_MESSAGE_SHOW_STARTED_AT_FORMAT = "show_started_at not dateFormat";
    public const ERROR_MESSAGE_SHOW_ENDED_AT          = "show_ended_at";
    public const ERROR_MESSAGE_SHOW_ENDED_AT_FORMAT   = "show_ended_at not dateFormat";
    public const ERROR_MESSAGE_IS_SHOW                = "is_show";
    public const ERROR_MESSAGE_DESC                   = "desc";
    public const ERROR_MESSAGE_THUMBNAIL              = "thumbnail";
    public const ERROR_MESSAGE_PAGE                   = "page";
    public const ERROR_MESSAGE_PAGE_SIZE              = "page_size";
    public const ERROR_MESSAGE_THUMBNAIL_TYPE         = "이미지 타입";
    public const ERROR_MESSAGE_THUMBNAIL_SIZE_2MB     = "2MB 이하 이미지만 업로드 가능";
    public const ERROR_MESSAGE_THUMBNAIL_1920_560     = "1920x560 까지만 업로드 가능";
    public const ERROR_MESSAGE_THUMBNAIL_413_271      = "413x271 까지만 업로드 가능";
    public const ERROR_MESSAGE_MAIN_TOP_BANNER        = "main top banner";
    public const ERROR_MESSAGE_MAIN_INTRO             = "main intro";
   
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
