<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-bg {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/library-bg.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
                                                    <!--Background-Image -->
<body class="bg-cover bg-center bg-no-repeat" style="background-image: url('images/library.jpg')">
<div class="min-h-screen flex flex-col">
        <header class="fixed top-0 w-full bg-blue-950 text-white shadow-md z-50">
            <!-- <img src="library.jpg" class="w-12 h-auto mr-3"> -->
            <div class="container mx-auto px-4 py-4 flex flex-col items-center">
                <div class="flex items-center">
                    <img src="images/logo2.png" class="w-12 h-auto mr-3">
                    <h1 class="text-3xl font-bold text-center">LIBRARY MANAGEMENT SYSTEM</h1>
                </div>

                <nav class="mt-4">
                    <ul class="flex space-x-6">
                        <?php if(isset($_SESSION['login_user'])): ?>
                            <li><a href="Main.php" class="text-white text-2xl font-bold hover:text-red-500 transition">
                                <in class="fas fa-home mr-"></i> HOME</a></li>

                            <li><a href="AdminMyprofile.php" class="text-white text-2xl font-bold hover:text-red-500 transition">
                                <i class="fas fa-user mr-1"></i> ADMINPROFILE</a></li>

                            <li><a href="books.php" class="text-white text-2xl font-bold hover:text-red-500 transition">
                                <i class="fas fa-book mr-1"></i> BOOKS</a></li>

                            
                            <div class="relative group">
                                <button class="flex items-center space-x-1 text-white hover:text-blue-600">
                                    <i class="fas fa-user-circle"></i>
                                    <span><?php echo $_SESSION['login_user']; ?></span>
                                    <i class="fas fa-chevron-down text-xs ml-1"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block z-50">
                                <a href="Logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                                     <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </nav>
                        <?php else: ?>
                            <li><a href="Main.php" class="text-white text-2xl  font-bold hover:text-red-500 transition">HOME</a></li>
                            <li><a href="LoginPage.php" class="text-white text-2xl  font-bold hover:text-red-500 transition">BOOKS</a></li>
                            <li><a href="LoginPage.php" class="text-white text-2xl  font-bold hover:text-red-500 transition">LOGIN</a></li>
                            <li><a href="Registration.php" class="text-white text-2xl font-bold hover:text-red-500 transition">SIGN IN</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="flex-grow hero-bg flex items-center justify-center text-white">
            <div class="container mx-auto px-4 py-16 text-center">
                <div class="bg-white bg-opacity-90 rounded-lg p-8 max-w-2xl mx-auto shadow-lg">
                    <h1 class="text-3xl md:text-4xl font-bold text-blue-800 mb-4  hover:text-red-500 transition">Welcome to Our Library</h1>
                    <div class="space-y-2 text-gray-700">
                        <p class="text-lg flex items-center justify-center  hover:text-red-500 transition">
                            <i class="fas fa-clock mr-2 text-blue-600"></i>
                            <span>Opens at: 09:00 AM</span>
                        </p>
                        <p class="text-lg flex items-center justify-center  hover:text-red-500 transition">
                            <i class="fas fa-clock mr-2 text-blue-600"></i>
                            <span>Closes at: 03:00 PM</span>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-blue-950 text-white py-6">
            <div class="container mx-auto px-4 text-center">
                <div class="flex flex-col md:flex-row justify-center space-y-2 md:space-y-0 md:space-x-8">
                    <p class="flex items-center justify-center">
                        <i class="fas fa-envelope mr-2"></i>
                        Email: Online.library@gmail.com
                    </p>
                    <p class="flex items-center justify-center">
                        <i class="fas fa-phone mr-2"></i>
                        Contact: 98045******
                    </p>
                </div>
                <p class="mt-4 text-blue-200">
                    &copy; <?php echo date("Y"); ?> Library Management System. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>