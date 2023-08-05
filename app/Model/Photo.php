<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    protected $table = "photos";
    protected $primaryKey = "photo_id";

    protected $guarded = ['photo_id'];
}
