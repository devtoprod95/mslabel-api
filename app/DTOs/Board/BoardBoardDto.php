<?php

namespace App\DTOs\Board;

use App\DTOs\Dto;

class BoardBoardDto extends Dto
{
    protected int $group_id         = 0;
    protected int $sub_id           = 0;
    protected string $user_id       = "";
    protected string $company       = "";
    protected string $title         = "";
    protected string $contact_name  = "";
    protected string $contact_email = "";
    protected string $contact_phone = "";
    protected string $password      = "";
    protected string $size          = "";
    protected string $purpose       = "";
    protected string $material      = "";
    protected string $shape         = "";
    protected string $quantity      = "";
    protected string $desc          = "";
    protected string $etc_file      = "";

    public function bind(mixed $data): void
    {
        
        $this->group_id      = $data["group_id"];
        $this->sub_id        = $data["sub_id"];
        $this->user_id       = session("admin_user")->sub->user->user_id;
        $this->company       = $data["company"];
        $this->title         = $data["title"];
        $this->contact_name  = $data["contact_name"];
        $this->contact_email = $data["contact_email"];
        $this->contact_phone = $data["contact_phone"];
        $this->password      = $data["password"];
        $this->size          = $data["size"];
        $this->purpose       = $data["purpose"];
        $this->material      = $data["material"];
        $this->shape         = $data["shape"];
        $this->quantity      = $data["quantity"];
        $this->desc          = $data["desc"];
        $this->etc_file      = $data["etc_file"];
    }
}