<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'title', 'canteen', 'domain', 'active'
    ];

    public function openingtimes()
    {
        return $this->belongsToMany(Company::class, 'company_openingtime')->withPivot('day', 'time_open', 'time_close');
    }
}
