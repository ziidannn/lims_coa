<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    use HasFactory;
    protected $table = 'samples';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'no_sample',
        'sampling_location',
        'sampling_date',
        'sampling_time',
        'date_received',
        'interval_testing_date',
        'logo',
    ];
}
