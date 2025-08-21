<?php 
require 'Database.php';

session_start();
if (!isset($_SESSION['login_user'])) {
    header("Location: LoginPage.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-indigo-950 reflect-below">
    <!-- Header -->
    <header class="bg-blue-950 text-white shadow-md fixed top-0 w-full z-50">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <img src="images/logo2.png" class="h-10 w-10" alt="Library Logo">
                <h1 class="text-xl font-bold">LIBRARY MANAGEMENT SYSTEM</h1>
            </div>
            
            <nav class="flex-1 flex justify-center ml-4">
                <div class="flex space-x-4 lg:space-x-6 items-center">
                <a href="Main.php" class="hover:bg-indigo-300 px-3 py-2 rounded transition">HOME</a>
                <a href="AdminBooks.php" class="bg-indigo-300 px-3 py-2 rounded">BOOKS</a>
                <a href="AdminFeedback.php" class="hover:bg-indigo-300 px-3 py-2 rounded transition">FEEDBACK</a>
                 <!-- Management Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button 
                    @click="open = !open"
                    class="hover:bg-indigo-300 px-3 py-2 rounded transition flex items-center">
                    MANAGEMENT <i class="fas fa-caret-down ml-1"></i>
                </button>
                <div 
                    x-show="open"
                    @click.away="open = false"
                    class="absolute bg-white text-gray-800 rounded-md shadow-lg mt-1 py-1 w-48 z-50 right-0"
                    style="display: none;"
                >
                    <a href="AddBook.php" class="block px-4 py-2 hover:bg-indigo-300 transition">Add Books</a>
                    <a href="Adminstudent.php" class="block px-4 py-2 hover:bg-indigo-300 transition">Student Info</a>
                    <a href="AdminRequest.php" class="block px-4 py-2 hover:bg-indigo-300 transition">Book Requests</a>
                    <a href="Adminissue_info.php" class="block px-4 py-2 hover:bg-indigo-300 transition">Issue Info</a>
                    <a href="Adminexperied.php" class="block px-4 py-2 hover:bg-indigo-300 transition">Experied Info</a>

                </div>
            </div>
            </ul>

            <!-- Add Alpine.js CDN  -->
            <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
                </div>
            </nav>
            <div class="flex items-center space-x-2 ml-4">
                <?php if(isset($_SESSION['login_user'])): ?>
                <div class="flex items-center space-x-2 ml-4">
                    <?php if (isset($row) && isset($row['pic'])): ?>
                    <img class="rounded-full h-8 w-8" src="images/<?php echo $row['pic']; ?>" alt="Profile">
                    <?php endif; ?>
                    <span class="hidden sm:inline">Welcome <?php echo $_SESSION['login_user']; ?></span>

                    <a href="logout.php" class="hover:text-blue-200 transition flex items-center ml-4">
                        <i class="fas fa-sign-out-alt mr-1"></i> LOGOUT
                    </a>
                </div>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="pt-24 pb-8 px-4 md:px-15">
    <div class="container mx-auto px-4 py-8 md:py-16">
        <!-- Search Bar -->
        <div class="bg-white p-4 md:p-6 rounded-lg shadow-md mb-8 md:mb-16">
            <div class="flex flex-col md:flex-row gap-4 items-center">
                <form class="w-full md:w-1/2 flex gap-2" id="searchForm">
                    <input type="text" id="book_search" name="search" placeholder="Search for books..." 
                           class="flex-grow px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="button" onclick="searchBooks()"
                            class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-search mr-1"></i> Search
                    </button>
                </form>
            </div>
        </div>
        <!-- Books Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b">
                <h2 class="text-center text-3xl font-bold text-gray-800">List of Books</h2>
            </div>
            
            <div class="overflow-x-auto">
                <?php
                $bookretrive = "SELECT * FROM books";
                $result = $conn->query($bookretrive);

                if ($result->num_rows > 0): ?>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-300">
                            <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Book Name</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Authors Name</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Edition</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Program</th>
                            <th class="px-6 py-6 text-left text-xs font-bold uppercase tracking-wider">Operations</th>

                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $row['BookId']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $row['BookName']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $row['Authors']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $row['Edition']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $row['Quantity']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $row['Status']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $row['Category']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $row['Program']; ?></td>
                                    <!--Buttons-->
                                    <td>
                                    <a href="update.php?updateid=<?php echo $row['BookId']; ?>"
                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg
                                    transition duration-200 shadow-md">Update

                                    </a>
                                   <a href="delete.php?deleteid=<?php echo $row['BookId']; ?>"onclick="return confirm('Are you sure you want to delete this book?');" 
                                   class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg
                                        transition duration-200 shadow-md ml-2">Delete</a></button>
                                    </td>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="p-8 text-center text-gray-500">
                        No books found in the database.
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Search Results Container -->
        <div id="searchresult" class="mt-8"></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>

        function searchBooks() {
            var booksearch = $("#book_search").val();

            if (booksearch !== "") {
                $.ajax({
                    url: "AdminBooksearch.php",
                    method: "POST",
                    data: { input: booksearch },
                    success: function(data) {
                        // Hide the main table and show search results
                        $("table").hide();
                        $("#searchresult").html(data).show();
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " - " + error);
                    }
                });
            } else {
                // If search is empty, show all books again
                $("table").show();
                $("#searchresult").empty();
            }
        }
        // Search on keyup with delay
        var searchTimer;
        $("#book_search").keyup(function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                searchBooks();
            }, 500);
        });
    </script>
</body>
</html>