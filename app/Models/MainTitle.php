<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainTitle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table      = 'main_titles';
    protected $guarded    = [];
    protected $fillable   = [];
    
}
