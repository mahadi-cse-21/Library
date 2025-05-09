<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Admin - Add New Book</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex">




    <!-- Main Content -->
    <div class="ml-20 mr-20 flex-1 p-8"> <!-- Reduced left and right margin (ml-20, mr-20) -->
        <div class="flex items-center mb-8">
            <a href="#" class="text-indigo-600 hover:text-indigo-800 mr-2">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Add New Book</h1>
        </div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif

        @if ($errors->any())
            <div class="alert alert-danger bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Add Book Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">

                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="col-span-2">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-200">Basic
                            Information</h2>
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title*</label>
                        <input type="text" id="title" name="title"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Enter book title">
                    </div>

                    <!-- Subtitle -->
                    <div class="mb-4">
                        <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                        <input type="text" id="subtitle" name="subtitle"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Enter a subtitle if exist" >

                    </div>
                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        
                        @if(count($categories) > 0)
                            <!-- Regular dropdown when categories exist -->
                            <select id="category_id" name="category_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        @else
                            <!-- Category creation form when no categories exist -->
                            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-4">
                                <p class="text-yellow-700 mb-2">No categories available. Please create one below:</p>
                                
                                <div class="flex space-x-2">
                                    <input type="text" id="new_category_name" name="new_category_name" required
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        placeholder="Enter new category name">
                                    
                                    <button type="button" id="create_category_btn" 
                                        class="px-4 py-2 bg-yellow-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        Create Category
                                    </button>
                                </div>
                                <input type="hidden" id="category_id" name="category_id" value="">
                            </div>
                        @endif
                    </div>



                    <!-- Author-->
                    <div class="mb-4">
                        <label for="author_id" class="block text-sm font-medium text-gray-700 mb-1">Author *</label>
                        <input type="text" id="author" name="author" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Enter author name">
                    </div>





                    <!-- -->
                    <div class="col-span-2 mt-2">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-200">Additional
                            Information</h2>
                    </div>



                    <!-- Language -->
                    <div class="mb-4">
                        <label for="language" class="block text-sm font-medium text-gray-700 mb-1">Language</label>
                        <select id="language" name="language"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Select a language</option>
                            <option value="English">English</option>
                            <option value="Hindi">Hindi</option>
                            <option value="Spanish">Spanish</option>
                            <option value="French">French</option>
                            <option value="German">German</option>
                            <!-- Add more as needed -->
                        </select>
                    </div>


                    <!-- Pages -->
                    <div class="mb-4">
                        <label for="pages" class="block text-sm font-medium text-gray-700 mb-1">Number of Pages</label>
                        <input type="number" id="pages" name="pages"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Enter total pages">
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" step="0.01" id="price" name="price"
                                class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                placeholder="0.00">
                        </div>
                    </div>
                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="Available">Available</option>
                            <option value="Processing">Processing</option>
                            <option value="Reserved">Reserved</option>
                        </select>
                    </div>


                    <!-- Quantity -->
                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                        <input type="number" id="quantity" name="quantity" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Number of copies" value="1">
                    </div>

                    <!--Available Quantity -->
                    <div class="mb-4">
                        <label for="available_quantity" class="block text-sm font-medium text-gray-700 mb-1">Available
                            Quantity *</label>
                        <input type="number" id="available_quantity" name="available_quantity" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Number of copies" value="1">
                    </div>


                    <!-- Book Cover Image -->
                    <div class="mb-4 col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Book Cover Image</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="cover"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="cover" name="cover" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4 col-span-2">
                        <label for="description"
                            class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Enter book description"></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-4 col-span-2 flex justify-end space-x-3">
                        <a href="{{ route('books.index') }}"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Back To Books
                        </a>



                        <!-- your input fields here -->

                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Add Book
                        </button>


                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const createCategoryBtn = document.getElementById('create_category_btn');
            
            if (createCategoryBtn) {
                createCategoryBtn.addEventListener('click', function() {
                    const categoryName = document.getElementById('new_category_name').value;
                    
                    if (!categoryName) {
                        alert('Please enter a category name');
                        return;
                    }
                    
                    // Send AJAX request to create category
                    fetch('{{ route("category.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ name: categoryName })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update hidden category ID field with the new category ID
                            document.getElementById('category_id').value = data.category.id;
                            
                            // Show success message
                            alert('Category created successfully!');
                            
                            // Optional: Replace the form with a success message showing the created category
                            const categoryDiv = document.querySelector('.bg-yellow-50');
                            categoryDiv.innerHTML = `
                                <div class="text-green-700">
                                    <p>Category "${data.category.name}" created successfully!</p>
                                    <p class="text-sm">This category will be used for the current book.</p>
                                </div>
                            `;
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while creating the category.');
                    });
                });
            }
        });
        </script>
    



</body>

</html>