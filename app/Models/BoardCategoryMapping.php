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
}
