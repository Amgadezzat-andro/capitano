<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded=[];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
    public function getImageAttribute()
    {
        return getImagePathFromDirectory($this->attributes['image'],'Brands');
    }
}
