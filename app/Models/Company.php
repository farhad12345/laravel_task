<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'email',
        'country_id',
        'company_code',
        'commercial_record_no',
        'commercial_record_image',
        'logo',
        'category_id',
        'created_at',
        'updated_at',
      ];
    public function orders()
{
    return $this->hasMany(Order::class);
}
}
