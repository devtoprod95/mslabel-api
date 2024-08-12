<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardEditorData extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table      = 'board_editor_datas';
    protected $guarded    = [];
    protected $fillable   = [];

    public function admin_user()
    {
        return $this->hasOne(AdminData::class, "user_id", "user_id");
    }
}
