<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CoffeeBrand;
use App\Models\CoffeeType;

class Coffee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'image', 
        'price', 
        'type', 
        'status', 
        'brand', 
        'description'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y'
    ];

    public function coffeeBrand()
    {
        return $this->belongsTo(CoffeeBrand::class, 'brand');
    }


    public function coffeeType()
    {
        return $this->belongsTo(CoffeeType::class, 'type');
    }
}
