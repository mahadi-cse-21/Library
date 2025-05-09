<?php

namespace App\Exports;

use App\Models\Borrow;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;


class OverdueBooksExport 
{
    
    public function downloadPDF()
    {
        // Fetch overdue books that are not returned yet
        $overdue_books = Borrow::where('due_date', '<', Carbon::today())
            ->whereNull('return_date')
            ->with('student.user', 'book_copy.book')
            ->get();

        // Generate the PDF and pass the data to the view
        $pdf = FacadePdf::loadView('exports.overdue_books_pdf', compact('overdue_books'));

        // Return the PDF for download
        return $pdf->download('overdue_books.pdf');
    }
    
}
