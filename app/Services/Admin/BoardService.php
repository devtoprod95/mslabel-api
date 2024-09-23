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

    public function list(string $type, Request $request): array
    {
        return $this->boardAbstract->list($type, $request);
    }

    public function detail(string $type, int $id): array
    {
        return $this->boardAbstract->detail($type, $id);
    }

    public function create(string $type, Request $request): array
    {
        return $this->boardAbstract->create($type, $request);
    }

    public function edit(string $type, int $id, Request $request): array
    {
        return $this->boardAbstract->edit($type, $id, $request);
    }

    public function reply(int $id, Request $request): array
    {
        return $this->boardAbstract->reply($id, $request);
    }

    public function delete(string $type, int $id): array
    {
        return $this->boardAbstract->delete($type, $id);
    }
}
