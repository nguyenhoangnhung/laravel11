<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quantity extends Model
{
    protected $fillable = ['size_id', 'color_id', 'value', 'product_id'];
}
