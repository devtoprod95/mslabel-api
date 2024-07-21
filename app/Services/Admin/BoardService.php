<?php

namespace App\Services\Admin;

use App\Abstracts\Admin\BoardAbstract;
use Illuminate\Http\Request;

class BoardService
{
    private BoardAbstract $boardAbstract;

    public function __construct(
        BoardAbstract $boardAbstract
    )
    {
        $this->boardAbstract = $boardAbstract;
    }

    public function create(string $type, Request $request): array
    {
        return $this->boardAbstract->create($type, $request);
    }
}
