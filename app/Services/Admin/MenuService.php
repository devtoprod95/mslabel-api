<?php

namespace App\Services\Admin;

use App\Abstracts\Admin\MenuAbstract;

class MenuService
{
    private MenuAbstract $menuAbstract;

    public function __construct(
        MenuAbstract $menuAbstract
    )
    {
        $this->menuAbstract = $menuAbstract;
    }

    public function mainList(): array
    {
        return $this->menuAbstract->mainList();
    }

    public function mainEdit(array $params): array
    {
        return $this->menuAbstract->mainEdit($params);
    }

    public function subList(array $params): array
    {
        return $this->menuAbstract->subList($params);
    }

    public function subMenuCreate(array $params): array
    {
        return $this->menuAbstract->subMenuCreate($params);
    }

    public function subEdit(array $params): array
    {
        return $this->menuAbstract->subEdit($params);
    }

    public function subDelete(int $id): array
    {
        return $this->menuAbstract->subDelete($id);
    }
}
