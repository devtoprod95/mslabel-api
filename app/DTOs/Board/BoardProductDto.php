<?php

namespace App\DTOs\Board;

use App\DTOs\Dto;

class BoardProductDto extends Dto
{
    protected int $group_id       = 0;
    protected int $sub_id         = 0;
    protected string $user_id     = "";
    protected string $title       = "";
    protected string $is_show     = "";
    protected string $desc        = "";
    protected string $main_img    = "";
    protected string $bottom_img1 = "";
    protected string $bottom_img2 = "";
    protected string $bottom_img3 = "";
    protected string $bottom_img4 = "";
    protected string $bottom_img5 = "";
    protected string $material    = "";
    protected string $size        = "";
    protected string $shape       = "";
    protected string $keywords    = "";

    public function bind(mixed $data): void
    {
        $this->group_id    = $data["group_id"];
        $this->sub_id      = $data["sub_id"];
        $this->user_id     = session("admin_user")->sub->user->user_id;
        $this->title       = $data["title"];
        $this->is_show     = $data["is_show"];
        $this->desc        = $data["desc"];
        $this->main_img    = $data["main_img"];
        $this->bottom_img1 = $data["bottom_img1"];
        $this->bottom_img2 = $data["bottom_img2"];
        $this->bottom_img3 = $data["bottom_img3"];
        $this->bottom_img4 = $data["bottom_img4"];
        $this->bottom_img5 = $data["bottom_img5"];
        $this->material    = $data["material"];
        $this->size        = $data["size"];
        $this->shape       = $data["shape"];
        $this->keywords    = $data["keywords"];
    }
}