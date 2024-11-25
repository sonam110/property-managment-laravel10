<?php

namespace App\Exports;

use App\Models\Lease;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaseExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Lease::select(
            'id',               // Lease ID
            'unique_id',               // Lease ID
            'property_id',      // Property ID
            'tenant_id',        // Tenant ID
            'load_taken',        // Tenant ID
            // Add other columns here or calculate extra columns as needed
        )->with('property','tenant')->get()->map(function($lease) {
            // Customize rows if additional fields or formatted data is needed
            return [
                'Lease ID' => $lease->unique_id,
                'Property ID' => $lease->property->property_name,
                'Tenant ID' => $lease->tenant->firm_name,
                'Load Taken' => $lease->load_taken, // Extra column
                'No of Units Consumed' => NULL,
                'FPPAS' => NULL,
                'TOD Rebate' => NULL,
                'Bill Date'  => NULL,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Lease ID',
            'Property ID',
            'Tenant ID',
            'Load Taken',
            'No of Units Consumed',
            'FPPAS',
            'TOD Rebate',
            'Bill Date',
        ];
    }
}
