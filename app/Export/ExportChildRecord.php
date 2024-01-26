<?php

namespace App\Export;

use App\Models\ChildPersonalInformation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportChildRecord implements FromCollection, WithHeadings, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $healthWorkerId;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->healthWorkerId = Session::get('userId');
    }

    public function collection()
    {
        $query = ChildPersonalInformation::join('child_health_records', 'child_personal_information.id', '=', 'child_health_records.child_id')
            ->where('child_personal_information.health_worker_id', $this->healthWorkerId)
            ->select(
                'child_personal_information.lastname',
                'child_personal_information.firstname',
                'child_personal_information.middlename'
            );

        // Add additional filters based on the provided parameters
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('child_health_records.created_at', [$this->startDate, $this->endDate]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Last Name',
            'First Name',
            'Middle Name',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply styles to specific cells or ranges
        $sheet->getStyle('A1:C1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 14, // Adjust the font size as needed
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4CAF50'], // Green background color
            ],
        ]);
    
        // Apply styles for the rest of the cells
        $sheet->getStyle('A2:C' . $sheet->getHighestRow())->applyFromArray([
            'font' => [
                'size' => 12, // Adjust the font size for non-heading cells
            ],
        ]);
    
        // You can add more styles as needed
    
        return $sheet;
    }
    
}
