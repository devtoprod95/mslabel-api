<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NoticeSubData extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table      = 'notice_sub_datas';
    protected $guarded    = [];
    protected $fillable   = [];
}
