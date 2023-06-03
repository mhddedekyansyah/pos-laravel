<?php

namespace App\Http\Traits\Accesors; 

use Illuminate\Database\Eloquent\Casts\Attribute;



trait HasNumberPriceFormat{
    /**
     * Interact with the any table has buying_price field.
     */
    protected function buyingPrice(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => 'Rp. ' . number_format($value, 0, '', '.')
        );
    }

    /**
     * Interact with the any table has selling_price field.
     */
    protected function sellingPrice(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => 'Rp. ' . number_format($value, 0, '', '.')
        );
    }
}