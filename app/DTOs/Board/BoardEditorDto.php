<?php

namespace App\DTOs\Board;

use App\DTOs\Dto;

class BoardEditorDto extends Dto
{
    protected int $group_id           = 0;
    protected int $sub_id             = 0;
    protected string $user_id         = "";
    protected string $title           = "";
    protected string $is_show         = "";
    protected string $desc            = "";
    protected string $image           = "";
    protected string $show_started_at = "";
    protected string $show_ended_at   = "";

    public function bind(mixed $data): void
    {
        $this->group_id        = $data["group_id"];
        $this->sub_id          = $data["sub_id"];
        $this->user_id         = session("admin_user")->sub->user->user_id;
        $this->title           = $data["title"];
        $this->is_show         = $data["is_show"];
        $this->desc            = $data["desc"];
        $this->image           = $data["image"];
        $this->show_started_at = $data["show_started_at"];
        $this->show_ended_at   = $data["show_ended_at"];
    }
}