<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-indigo-950">
    <header class="bg-blue-950 text-white shadow-md fixed top-0 w-full z-50">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <img src="limages/ogo2.png" class="h-10 w-10" alt="Library Logo">
                <h1 class="text-xl font-bold">LIBRARY MANAGEMENT SYSTEM</h1>
            </div>
             <!--Header-->
            <nav class="flex-1 flex justify-center ml-4">
                <div class="flex space-x-4 lg:space-x-6 items-center">
                    <a href="Main.php" class="hover:text-blue-200 transition flex items-center whitespace-nowrap">
                        <i class="fas fa-home mr-1"></i> HOME
                    </a>
                    <a href="AdminBooks.php" class="hover:text-blue-200 transition flex items-center whitespace-nowrap">
                        <i class="fas fa-book mr-1"></i> BOOKS
                    </a>
                    <!-- <a href="fine.php" class="hover:text-blue-200 transition flex items-center whitespace-nowrap">
                        <i class="fas fa-check-circle mr-1"></i> FINE
                    </a> -->
                <!-- Management Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button 
                    @click="open = !open"
                    class="hover:bg-blue-700 px-3 py-2 rounded transition flex items-center">
                    MANAGEMENT <i class="fas fa-caret-down ml-1"></i>
                </button>
                <!--DropDown-->
                <div 
                    x-show="open"
                    @click.away="open = false"
                    class="absolute bg-white text-gray-800 rounded-md shadow-lg mt-1 py-1 w-48 z-50 right-0"
                    style="display: none;">
                    <a href="AddBook.php" class="block px-4 py-2 hover:bg-blue-100 transition">Add Books</a>
                    <a href="Adminstudent.php" class="block px-4 py-2 hover:bg-blue-100 transition">Student Info</a>
                    <a href="AdminRequest.php" class="block px-4 py-2 hover:bg-blue-100 transition">Book Requests</a>
                    <a href="Adminissue_info.php" class="block px-4 py-2 hover:bg-blue-100 transition">Issue Info</a>
                    <a href="Adminexperied.php" class="block px-4 py-2 hover:bg-blue-100 transition">Experied List</a>
                </div>
        </div>
    </header>   
</body>
</html>