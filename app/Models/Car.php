<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    public function model()
    {
        return $this->belongsTo(CarModel::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

}
