<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_distributor', 'name', 'price', 'category', 'description', 'image', 'discount'
    ];

}
