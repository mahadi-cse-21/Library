<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Book_Copy;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\Requests;
use App\Models\Reservation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BrowseController extends Controller
{
    //public function index(Request $request): View
    public function index(Request $request): View
    {
        $query = Book::with('category.parent', 'book_copy');
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
    
        // Filter by availability
        if ($request->availability === 'available') {
            $query->where('available_quantity', '>', 0);
        }
    
        // Filter by search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');
            });
        }
    
        // Sorting
        switch ($request->sort) {
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'author':
                $query->orderBy('author');
                break;
            case 'popularity':
                $query->orderBy('rating', 'desc');
                break;
        }
    
        $studentId = auth()->user()->id;
    
        // Get books that the student has requested/borrowed
        $bookIds = Requests::with('bookCopy')
        ->where('student_id', $studentId)
        ->whereIn('status', ['pending', 'approved'])
        ->get()
        ->pluck('bookCopy.book_id')
        ->filter() // Remove nulls in case any bookCopy is missing
        ->unique()
        ->toArray();

        $reserveBookIds = Reservation::where('student_id', $studentId)
        ->whereIn('status', ['pending', 'confirmed'])
        ->get()
        ->pluck('book_id')
        ->filter()
        ->unique()
        ->toArray();

        
        // Get the books based on filters applied (no need to filter by bookId here as you'll handle it in the view)
        $books = $query->paginate(6); // appends filters to pagination links

    
        $categories = Category::withCount('books')->get();
    
        return view('student.browse', [
            'categories' => $categories,
            'bookIds' => $bookIds, // List of bookIds the student has already requested or borrowed
            'books' => $books,
           
            'reserveBookIds'=> $reserveBookIds,
        ]);
    }

    
    


}
