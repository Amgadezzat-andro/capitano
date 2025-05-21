<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    public function panelings()
    {
        return $this->belongsToMany(Paneling::class,'paneling_colors')
        ->withPivot('embroider_color_id')
        ->withTimestamps();
    }
    
}
