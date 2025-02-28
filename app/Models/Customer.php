<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'customer',
        'address',
        'name',
        'email',
        'phone',
        'created_at',
    ];

    public function Subjects()
    {
        return $this->belongsToMany(Subject::class, 'coa_subjects', 'customer_id', 'subject_id');
    }
    // public function institute_subjects()
    // {
    //     return $this->hasMany(InstituteSubject::class, 'institute_id');
    // }
}
