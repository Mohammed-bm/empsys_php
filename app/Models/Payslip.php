<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    protected $table = 'payslip';
    
    // Keep timestamps false as defined in your model
    public $timestamps = false;

    protected $fillable = [
        'name',
        'percentage',
        'type',
        'is_active',
    ];
}
