<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoaSubject extends Model
{
    use HasFactory;
    protected $table = 'coa_subjects';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'customer_id',
        'subject_id',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function Subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id','id');
    }
}
