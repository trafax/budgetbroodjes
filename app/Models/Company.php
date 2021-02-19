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

    public function openingtime()
    {
        return $this->belongsToMany(Company::class, 'company_openingtime')->where('day', date('w'))->where('time_open','<=',date('h:i'))->where('time_close','>=',date('h:i'))->withPivot('day', 'time_open', 'time_close')->first();
    }

    public function nextopeningtime()
    {
        return $this->belongsToMany(Company::class, 'company_openingtime')->where('day', date('w'))->where('time_open','>=',date('h:i'))->withPivot('day', 'time_open', 'time_close')->first();
    }

    public function isOpen()
    {
        $is_open = $this->belongsToMany(Company::class, 'company_openingtime')->where('day', date('w'))->where('time_open','<=',date('h:i'))->where('time_close','>=',date('h:i'))->withPivot('day', 'time_open', 'time_close')->first();

        return $is_open ? true : false;
    }
}
