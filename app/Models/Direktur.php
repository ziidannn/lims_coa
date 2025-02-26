<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direktur extends Model
{
    use HasFactory;
    protected $table = 'direkturs';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'name',
        'ttd',
    ];
}
