<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NoticeGroupData extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table      = 'notice_group_datas';
    protected $guarded    = [];
    protected $fillable   = [];

    public function sub_menus ()
    {
        return $this->hasMany(NoticeSubData::class, "group_id", "id")
        ->orderBy("rank", "asc")
        ->orderBy("title", "asc");
    }
}
