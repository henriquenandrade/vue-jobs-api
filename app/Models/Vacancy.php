<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
        'title',
        'type',
        'description',
        'location',
        'salary',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
