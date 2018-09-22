<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SizeColor extends Model
{
    protected $fillable = ['size_id', 'color_id', 'product_id'];
}
