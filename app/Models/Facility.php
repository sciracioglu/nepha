<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;
    protected $primary = 'id';
    protected $fillable = [
        'facility',
        'country',
        'created_at',
        'updated_at'
    ];
}
