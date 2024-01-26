<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class HealthWorker extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
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
        '_token',
    ];

    protected $hidden = [
        'password', // Hide the password when the model is serialized
    ];

    public function childPersonalInformation()
    {
        return $this->hasMany(ChildPersonalInformation::class);
    }

    public function childHealthRecords()
    {
        return $this->hasMany(ChildHealthRecord::class);
    }
}