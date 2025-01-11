<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table='customers';
    protected $fillable = [
        'id',
        'branch_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
    ];
}
