<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'emp_name',
        'employee_number',
        'email',
        'phone',
        'base_salary',
        'function_name',
        'pan_number',
        'designation',
        'uan',
        'pf_account_number',
        'bank_details',
        'esi_number',
        'joining_date',
        'location',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
