<?php

namespace App\Http\Traits\Mutators;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;


trait HasSlug{
    /**
     * Interact with the any table has slug field.
     */
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Str::slug($value),
        );
    }
}