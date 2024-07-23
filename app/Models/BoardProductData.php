<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardProductData extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table      = 'board_product_datas';
    protected $guarded    = [];
    protected $fillable   = [];
}
