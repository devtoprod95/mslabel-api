<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OneToFiftyScore extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = "games";
    protected $table      = 'one_to_fifty_scores';
    protected $guarded    = [];
    protected $fillable   = [];
}
