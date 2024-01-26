<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildPersonalInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'health_worker_id',
        'municipality',
        'barangay',
        'sitio',
        'lastname',
        'firstname',
        'middlename',
        'birthday',
        'sex',
        'mother_lastname',
        'mother_firstname',
        'mother_middlename',
        'mother_birthday',
        'mother_occupation',
        'father_lastname',
        'father_firstname',
        'father_middlename',
        'father_birthday',
        'father_occupation',
        'contact_number',
        // Add other columns as needed
    ];

    // Define relationships if needed
    public function healthWorker()
    {
        return $this->belongsTo(HealthWorker::class, 'health_worker_id');
    }

    public function healthRecords()
    {
        return $this->hasMany(ChildHealthRecord::class);
    }
}
