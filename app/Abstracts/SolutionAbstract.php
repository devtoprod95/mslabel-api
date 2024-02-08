<?php

namespace App\Abstracts;

use App\Constants\SolutionErrorMessageConstant;
use App\Interfaces\SolutionInterface;
use Exception;
use InvalidArgumentException;

abstract class SolutionAbstract implements SolutionInterface
{
    private array $solutionLifeStyleTags;
    private array $returnMsg = [
        "isSuccess" => false,
        "msg"       => "변경 사항이 없거나 처리가 실패하였습니다. 관리자에 문의 바랍니다.",
        "data"      => [],
    ];

    public function __construct(array $solutionLifeStyleTags)
    {
        $this->solutionLifeStyleTags = $solutionLifeStyleTags;
    }

    public function solutionResult(array $userLifeStyleTags): array
    {
        $returnMsg = $this->returnMsg;

        try {
            if (empty($this->solutionLifeStyleTags)) {
                throw new InvalidArgumentException("솔루션 라이프스타일 태그가 전달되지 않았습니다.");
            }
            if (empty($userLifeStyleTags)) {
                throw new InvalidArgumentException("사용자 라이프스타일 태그가 전달되지 않았습니다.");
            }

            $tagRank = ['count' => []];
            # 1. 솔루션 별로 태그 카운트를 정리
            foreach ($userLifeStyleTags as $userLifeStyleTag) {
                foreach ($this->solutionLifeStyleTags as $tagName => $lifeStyleTag) {
                    if (in_array($userLifeStyleTag, $lifeStyleTag)) {
                        if (!isset($tagRank[$tagName])) {
                            $tagRank[$tagName] = [];
                            $tagRank["count"][$tagName] = 0;
                        }
                        if (!in_array($userLifeStyleTag, $tagRank[$tagName])) {
                            $tagRank[$tagName][] = $userLifeStyleTag;
                            $tagRank["count"][$tagName] += 1;
                        }
                    }
                }
            }

            if( count($tagRank["count"]) < 1 ){
                throw new InvalidArgumentException(SolutionErrorMessageConstant::getNotHaveErrorMessage("USERLIFESTYLETAGS"));
            }

            # 2. 솔루션에 속한 태그 가운트 별로 정리 후 반환
            arsort($tagRank['count']); // 내림차순으로 정렬
            $result = [];
            foreach ($tagRank['count'] as $solutionName => $count) {
                $result["recomSolutionRank"][] = $solutionName;
                $result["includeTagCount"][$solutionName] = $count;
            }

            $returnMsg = [
                "isSuccess" => true,
                "msg"       => "",
                "data"      => $result,
            ];
        } catch (InvalidArgumentException $e) {
            $returnMsg["msg"] = $e->getMessage();
        }  catch (Exception $e) {
            $returnMsg["msg"] = "관리자에 문의바랍니다.";
        }

        return $returnMsg;
    }
}
