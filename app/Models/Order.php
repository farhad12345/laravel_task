<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=[
        'company_id',
        'order_no',
        'city_from',
        'city_to',
        'price',
        'order_images',
        'created_at',
        'updated_at',
      ];
    public function company()
{
    return $this->belongsTo(Company::class);
}
}
