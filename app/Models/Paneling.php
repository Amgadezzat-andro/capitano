<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;


class Paneling extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded=[];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    public static function boot()
    {
        parent::boot();
        // static::addGlobalScope('active',function (Builder $builder){
        //         $builder->where('status',1);
        // });

    }
    public function getImageAttribute()
    {
        return getImagePathFromDirectory($this->attributes['image'],'Panelings');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function colors()
    {
        return $this->belongsToMany(Color::class,'paneling_colors')
        ->withPivot('embroider_color_id')
        ->withTimestamps();
    }
    public function specifications()
    {
        return $this->hasMany(PanelingSpecification::class);
    }



}
