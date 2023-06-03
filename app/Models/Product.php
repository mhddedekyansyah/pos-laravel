<?php

namespace App\Models;

use App\Http\Traits\Accesors\HasNumberPriceFormat;
use App\Http\Traits\Mutators\HasSlug; 
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;


class Product extends Model 
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'product_code',
        'product_name',
        'slug',
        'buying_date',
        'buying_price',
        'selling_price',
    ];

      /**
     * Get the user's image.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->product_code = IdGenerator::generate(['table' => 'products', 'field' => 'product_code' ,'length' => 10, 'prefix' => 'P-']);
        });
    }
}
