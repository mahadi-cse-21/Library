<?php

namespace App\Exports;

use App\Models\Borrow;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;

class OverdueBooksExport
{
    public function downloadPDF()
    {
        $overdue_books = Borrow::where('due_date', '<', Carbon::today())
            ->whereNull('return_date')
            ->with('student.user', 'book_copy.book')
            ->get();

        $html = view('exports.overdue_books_pdf', compact('overdue_books'))->render();

        // Load mPDF font configuration
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'autoScriptToLang' => true,
            'fontDir' => array_merge($fontDirs, [
                resource_path('fonts'),
            ]),
            'fontdata' => $fontData + [
                'notosansbengali' => [
                    'R' => 'NotoSansBengali.ttf',
                ],
            ],
            'default_font' => 'notosansbengali',
        ]);


        $mpdf->WriteHTML($html);
        return $mpdf->Output('overdue_books.pdf', 'I'); // Show in browser
    }
}
