<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'foodticket_id', 'title', 'slug', 'description', 'price', 'old', 'image'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function extras()
    {
        return $this->belongsToMany(Extra::class)->withPivot('title', 'price');
    }
}
