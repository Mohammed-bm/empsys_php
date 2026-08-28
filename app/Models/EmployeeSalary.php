<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    protected $table = 'employee_salary';
    public $timestamps = false;

    protected $fillable = [
        'employee_number',
        'Leave_count',
        'Sick_Leave',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_number', 'employee_number');
    }
}
