<?php 
require 'Database.php';
require 'BookRecommend.php';
session_start();
if (!isset($_SESSION['login_user'])) {
    header("Location: student_login.php"); 
    exit();
}

// Handle book request submission
if (isset($_POST['submit1'])) {
    if (isset($_SESSION['login_user']) && !empty($_POST['BookName'])) {
        $username = $_SESSION['login_user'];
        $bookname = $_POST['BookName'];
        
        // Check if book exists
        $bookCheck = mysqli_query($conn, "SELECT * FROM books WHERE BookName = '$bookname'");
        if (mysqli_num_rows($bookCheck) > 0) {
            // Insert into issue_book table
            $insertSql = "INSERT INTO issue_book (username, bookname, approve, issue, returnn) 
                          VALUES ('$username', '$bookname', 'Pending', '', '')";
            
            if (mysqli_query($conn, $insertSql)) {
                header("Location: request.php");
                exit();
            } else {
                $error = "Error submitting request: " . mysqli_error($conn);
            }
        } else {
            $error = "Book ID not found";
        }
    } else {
        $error = "Please enter a valid Book ID.";
    }
}
?>
    <!--show number of message-->
    <?php
    $r=mysqli_query($conn,"SELECT COUNT(status) as total FROM message where status='no' and username='$_SESSION[login_user]' and sender='admin' ;");
    $c=mysqli_fetch_assoc($r);
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-indigo-950">
    <!-- Header -->
    <header class="bg-blue-950 text-white shadow-md fixed top-0 w-full z-50">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <img src="images/logo2.png" class="h-10 w-10" alt="Library Logo">
                <h1 class="text-xl font-bold">LIBRARY MANAGEMENT SYSTEM</h1>
            </div>
            
            <nav class="flex-1 flex justify-center ml-4">
                <div class="text-xl flex space-x-4 lg:space-x-6 items-center">
                    <a href="Main.php" class="hover:text-blue-200 transition flex items-center whitespace-nowrap">
                        HOME
                    </a>
                    <a href="books.php" class="hover:text-blue-200 transition flex items-center whitespace-nowrap">
                      BOOKS
                    </a>
                    <a href="feedback.php" class="hover:text-blue-200 transition flex items-center whitespace-nowrap">
                     FEEDBACK
                    </a>
                    <a href="request.php" class="hover:text-blue-200 transition flex items-center whitespace-nowrap">
                         REQUESTS
                    </a>
                </div>
                
            </nav>
                
            <?php if(isset($_SESSION['login_user'])): ?>
            <div class="flex items-center space-x-2 ml-4">
                <?php if (isset($row) && isset($row['pic'])): ?>
                <img class="rounded-full h-8 w-8" src="images/<?php echo $row['pic']; ?>" alt="Profile">
                <?php endif; ?>
                <span class="hidden sm:inline">Welcome <?php echo $_SESSION['login_user']; ?></span>
        
                </a>
                <a href="logout.php" class="hover:text-blue-200 transition flex items-center ml-4">
                    <i class="fas fa-sign-out-alt mr-1"></i> LOGOUT
                </a>
            </div>
            <?php endif; ?>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="pt-24 pb-8 px-15">
        <!-- Error Message Display -->
        <?php if(isset($error)): ?>
        <div class="container mx-auto mb-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo $error; ?></span>
            </div>
        </div>
        <?php endif; ?>

        <!-- Search Section -->
          <div class="p-2 md:p-4 rounded-lg shadow-md mb-8 md:mb-16">
        <div class="container mx-auto mt-4">
            <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
                <!-- Search Form -->
                <form class="w-full md:w-1/2 flex gap-2" id="searchForm">
                    
                    <input type="text" id="book_search" name="search" placeholder="Search for books..." 
                           class="flex-grow px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="button" onclick="searchBooks()"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-search mr-1"></i> Search
                    </button>
                </form>
                
                <!-- Request Book Form -->
                <form action="books.php" method="post" class="w-full md:w-1/2 flex gap-2">
                    <input type="text" name="BookName" placeholder="Enter BookName" required
                           class="flex-grow px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" name="submit1" 
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                        Request
                    </button>
                </form>
            </div>
        </div>
        </div>
        <!-- Books Table Section -->
        <div class="container mx-auto mt-14">
            <h2 class="text-3xl font-bold text-center mb-8 text-white">List of Books</h2>
        
            <?php
            $bookretrive = "SELECT * FROM books";
            $result = $conn->query($bookretrive);

            if ($result->num_rows > 0): ?>
                <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-300 text-black">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Book Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Authors Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Edition</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Category</th>

                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Program</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-300 transition">
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $row['BookId']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $row['BookName']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $row['Authors']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $row['Edition']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $row['Quantity']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php echo $row['Status'] == 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                        <?php echo $row['Status']; ?>
                                    </span>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $row['Category']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?php echo $row['Program']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-8 bg-white rounded-lg shadow">
                    <p class="text-xl text-gray-600">No books found</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Search Results Container -->
        <div id="searchresult" class="container mx-auto mt-8"></div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function searchBooks() {
            var booksearch = $("#book_search").val();

            if (booksearch !== "") {
                $.ajax({
                    url: "booksearch.php",
                    method: "POST",
                    data: { input: booksearch },
                    success: function(data) {
                        $(".container table").hide();
                        $("#searchresult").html(data).show();
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " - " + error);
                    }
                });
            } else {
                $(".container table").show();
                $("#searchresult").empty();
            }
        }
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