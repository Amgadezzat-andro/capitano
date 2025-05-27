<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelingSpecification extends Model
{
    use HasFactory;
    protected $table = 'paneling_specifications';
    protected $guarded = [] ;
    protected $appends = ['price_after_vat'];
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y'
    ];
    public function paneling()
    {
        return $this->belongsTo(Paneling::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function model()
    {
        return $this->belongsTo(CarModel::class);
    }
    public function getPriceAfterVatAttribute()
    {
        // put vat here ??!!
        return $this->price ;
    }
}
