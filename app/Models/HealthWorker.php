<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthWorker extends Model
{
    use HasFactory;
    protected $fillable = [
        'role',
        'profile_picture',
        'last_name',
        'first_name',
        'middle_name',
        'municipality',
        'barangay',
        'sitio',
        'email',
        'contact_number',
        'password',
    ];


}
