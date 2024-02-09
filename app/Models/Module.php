<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
class Module extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'status',
        'created_at',
        'updated_at',
      ];
      public  function permissions()
      {
          return $this->hasMany(Permission::class);
      }
}
