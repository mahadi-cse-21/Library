<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Student::all();
    }
    public function headings(): array
    {
        return [
            'id', // user_id
            'Student ID',
            'Department',
            'Year',
            'Semester',
            'Status',
            'Max_allowed_books',
            'Current_borrows',
            'Book_borrowed'
        ];
    }
}
