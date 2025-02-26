<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Param_AmbientAir extends Model
{
    use HasFactory;
    protected $table = 'param_ambient_airs';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'no_coa',
        'customer_id',
        'sample_receive_date',
        'sample_analysis_date',
        'report_date',
        'direktur_id',
        'kode_qr',
    ];
}
