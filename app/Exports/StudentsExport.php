<?php

namespace App\Exports;

use App\Models\Students;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    public function query()
    {
        return Students::query();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Symbol Number',
            'Subject',
            'Date of Birth',
            'Status',
            'Marks'
            // Add more headings as needed
        ];
    }

    public function map($student): array
    {
        // Fetch subject name and filter by created_by user ID
        $subject = Subject::where('id', $student->subject_id)
            ->where('created_by', Auth::user()->id)
            ->first();

        return [
            $student->name,
            $student->symbol_number,
            $subject ? $subject->name : 'N/A', // Use subject name or 'N/A' if not found
            $student->date_of_birth,
            $student->status,
            $student->marks

            // Map more data as needed
        ];
    }
}
