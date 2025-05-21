<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarModel extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'models';
    protected $guarded=[];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    // Accessor for formatting
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
    public function Brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function getImageStartYearAttribute()
    {
        return getImagePathFromDirectory($this->attributes['image_start_year'],'Models');
    }   
    public function getImageEndYearAttribute()
    {
        return getImagePathFromDirectory($this->attributes['image_end_year'],'Models');
    }
}
