<?php

namespace App\Services;

use App\Abstracts\SolutionAbstract;
use App\Constants\SolutionConstant;

class FitnessCoachService extends SolutionAbstract
{
    public function __construct()
    {
        parent::__construct(SolutionConstant::TAG_LIST[SolutionConstant::SOLUTION_FITNESS]);
    }

    public function solutionResult(array $userLifeStyleTags): array
    {
        return parent::solutionResult($userLifeStyleTags);
    }
}
