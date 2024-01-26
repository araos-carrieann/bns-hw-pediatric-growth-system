<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildHealthRecord extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'child_id',
        'health_worker_id',
        'weight',
        'height',
        'bmi',
        'bmi_classification',
        'medical_condition',
        'vaccine_received',
        'age',
        // Add other columns as needed
    ];

    // Define relationships if needed
    public function childPersonalInformation()
    {
        return $this->belongsTo(ChildPersonalInformation::class, 'child_id');
    }
}
