<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageData extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table      = 'image_datas';
    protected $guarded    = [];
    protected $fillable   = [];
}
