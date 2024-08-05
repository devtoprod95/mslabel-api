<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardCategoryMapping extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table      = 'board_category_mappings';
    protected $guarded    = [];
    protected $fillable   = [];

    public function board()
    {
        return $this->belongsTo(BoardBoardData::class, 'board_id');
    }

    public function category()
    {
        return $this->belongsTo(BoardCategoryData::class, 'category_id');
    }
}
