<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class FlashSale extends Model
{
    protected $fillable = ['product_id', 'discount_price', 'start_date', 'end_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
