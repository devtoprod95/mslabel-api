<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardCategoryData extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table      = 'board_category_datas';
    protected $guarded    = [];
    protected $fillable   = [];

    public function boards()
    {
        return $this->belongsToMany(BoardBoardData::class, 'board_category_mappings', 'category_id', 'board_id');
    }
}
