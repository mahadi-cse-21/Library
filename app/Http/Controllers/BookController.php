<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Book_Copy;
use App\Models\Borrow;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;





class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
           $query = Book::query();

    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('author', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $books = $query->with('category')->paginate(10);
    $categories = Category::all();

        return view('admin.books', ['books' => $books, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): view
    {
        //
        // if you define the relationship

        $categories = Category::all();
        return view('admin.books', ['categories' => $categories]);
    }

    public function addnewbook()
    {

        $categories = Category::all();

        return view('admin.addNewBook', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author' => 'required|string|max:255',
            'language' => 'nullable|string|max:255',
            'pages' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'status' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'available_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // for image upload
        ]);



        // Handle image upload

        if ($request->hasFile('cover')) {

            $imageName = time() . '.' . $request->cover->extension();
            $imagePath = $request->file('cover')->storeAs('book_covers', $imageName, 'public');
            $validated['cover'] = $imagePath; // Save path in DB if you have a column
        }



        // Create the book
        $book = Book::create($validated);

        
        return redirect()->back()->with('success', 'Book added successfully.');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //

        $borrows = Borrow::with('student.user')->where('book_id', $book->id)->get();


        return view('admin.books_actions.show', [
            'book' => $book,
            'borrows' => $borrows,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book): view
    {
        //
        $categories = Category::all();
        return view('admin.books_actions.edit', [
            'book' => $book,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|string|in:available,processing,reserved',
            'quantity' => 'required|numeric',
            'available_quantity' => 'required|numeric',
            'description' => 'nullable',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle cover upload and delete old one
        if ($request->hasFile('cover')) {
            // Delete the old cover from storage
            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }

            // Store new cover
            $imageName = time() . '.' . $request->cover->extension();
            $imagePath = $request->file('cover')->storeAs('book_covers', $imageName, 'public');
            $validated['cover'] = $imagePath;
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
