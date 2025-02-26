<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'subjects';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'no_sample',
        'name',
    ];
}
