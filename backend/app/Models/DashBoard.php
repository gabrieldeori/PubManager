<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashBoard extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_income',
        'total_outcome',
    ];

    protected $table = 'dashboard';

}
