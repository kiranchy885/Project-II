<?php
session_start();
?>
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
                <img src="images/logo2.png" class="h-10 w-10" alt="Library Logo">
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
                    <a href="AdminRequest.php" class="hover:text-blue-200 transition flex items-center">
                        <i class="fas fa-clipboard-list mr-2"></i> BOOK REQUEST
                    </a>
                    <a href="AdminFeedback.php" class="hover:text-blue-200 transition flex items-center whitespace-nowrap">
                        <i class="fas fa-comment mr-1"></i> FEEDBACK
                    </a>
                    <a href="Logout.php" class="hover:text-blue-200 transition">
                        <i class="fas fa-sign-out-alt"></i> LOGOUT
                    </a>
                    <!-- <ul class="nav navbar-nav navbar-right">
                        <a href="message.php" class="hover:text-blue-200 transition flex items-center whitespace-nowrap">
                        <i class="fas fa-envelope mr-1"></i>Mes -->
            
                        <!-- <span class="flex items-center">
                            <i class="fas fa-user mr-2"></i> <?php echo $_SESSION['login_user']; ?>
                        </span> -->
             
            </div>
            </div>
        </div>
    </header>
</body>
</html>