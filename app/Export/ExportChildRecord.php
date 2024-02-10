<?php

namespace App\Export;

use App\Models\HealthWorker;
use App\Models\ChildPersonalInformation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ExportChildRecord implements FromCollection, WithHeadings, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $healthWorkerId;
    protected $healthWorkerBrgy;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->healthWorkerId = Session::get('userId');
        $this->healthWorkerBrgy = session('UserBrgy');
    }


    public function collection()
    {
        $query = ChildPersonalInformation::join('child_health_records', 'child_personal_information.id', '=', 'child_health_records.child_id')
            ->select(

                'child_personal_information.lastname',
                'child_personal_information.firstname',
                'child_personal_information.middlename',
                'child_personal_information.municipality',
                'child_personal_information.barangay',
                'child_personal_information.sitio',
                'child_personal_information.birthday',
                'child_health_records.age',
                'child_personal_information.sex',
                'child_personal_information.mother_lastname',
                'child_personal_information.mother_firstname',
                'child_personal_information.mother_middlename',
                'child_personal_information.mother_birthday',
                'child_personal_information.mother_occupation',
                'child_personal_information.father_lastname',
                'child_personal_information.father_firstname',
                'child_personal_information.father_middlename',
                'child_personal_information.father_birthday',
                'child_personal_information.father_occupation',
                'child_personal_information.contact_number',
                'child_health_records.created_at',
                'child_health_records.height',
                'child_health_records.weight',
                'child_health_records.bmi',
                'child_health_records.bmi_classification',
                'child_health_records.medical_condition',
                'child_health_records.vaccine_received'
            )
            ->orderBy('child_health_records.created_at', 'DESC');

        // Add additional filters based on the provided parameters
        $role = HealthWorker::where('id', $this->healthWorkerId)->value('role');

        if ($role === 'bhw-user') {
            $query->where('child_personal_information.health_worker_id', $this->healthWorkerId);
        }else if($role === 'admin'){
            $query->where('child_personal_information.barangay', $this->healthWorkerId);
        }
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('child_health_records.created_at', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }


    public function headings(): array
    {
        return [
            "Child's Last Name",
            "Child's First Name",
            "Child's Middle Name",
            'Municipality',
            'Barangay',
            'Sitio',
            'Birthday',
            'Age(Month)',
            'Sex',
            "Mother's Last Name",
            "Mother's First Name",
            "Mother's Middle Name",
            "Mother's Birthday",
            "Mother's Occupation",
            "Father's First Name",
            "Father's Last Name",
            "Father's Middle Name",
            "Father's Birthday",
            "Father's Occupation",
            "Contact Number",
            "Date Measured",
            'Height',
            'Weight',
            'BMI',
            'BMI Classification',
            'Medical Condition',
            'Vaccine Received',


        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set the sheet to landscape mode
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

        // Apply styles to specific cells or ranges
        $sheet->getStyle('A1:AA1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 14, // Adjust the font size as needed
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4CAF50'], // Green background color for header
            ],
        ]);

        // Loop through each row and apply background color based on the value in column D
        for ($row = 2; $row <= $sheet->getHighestRow(); $row++) {
            $value = $sheet->getCell('Y' . $row)->getValue();
            $bgColor = $this->getBgColorBasedOnValue($value);

            $sheet->getStyle('Y' . $row)->applyFromArray([
                'font' => [
                    'size' => 12, // Adjust the font size for non-heading cells
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => $bgColor],
                ],
            ]);
        }

        // You can add more styles as needed

        return $sheet;
    }

    private function getBgColorBasedOnValue($value)
    {
        // Example: Change background color to red if the value is 'Obese'
        if ($value === 'Normal weight') {
            return Color::COLOR_GREEN;
        }elseif ($value === 'Underweight') {
            return Color::COLOR_RED;
        }else if($value === 'Obese') {
            return Color::COLOR_YELLOW;
        }elseif ($value === 'Overweight') {
            return Color::COLOR_DARKYELLOW;
        }

        // Default background color
        return 'FFFFFF';
    }
}
