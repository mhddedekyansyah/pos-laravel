<?php

namespace App\Models;

use App\Http\Traits\Mutators\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory, HasSlug;

    protected  $fillable = ['category_name', 'slug'];

}
