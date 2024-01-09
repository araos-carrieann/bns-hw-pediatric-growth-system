<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'municipal',       
        'barangay',
        'sitio',
        'lastname',
        'firstname',
        'middlename',
        'birthday',
        'sex',
        'weight',
        'height',
        'bmi',
        'bmi_classification',
        'medical_condition',
        'vaccine_received',
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
    ];
}
