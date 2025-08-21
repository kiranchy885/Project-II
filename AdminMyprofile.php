<?php
require 'Database.php';
require 'AdminNavbar.php';
// session_start();

// Check if the user is logged in
if (!isset($_SESSION['login_user'])) {
    header("Location: AdminMyprofile.php");
    exit();
}

// Get username from session
$username = $_SESSION['login_user'];

// Fetch user data from the database
$sql = mysqli_query($conn, "SELECT * FROM admin_tbl WHERE username = '$username'");

if ($sql && mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);
} else {
    echo "User data not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .profile-img {
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body class="bg-blue-50">
    <div class="container mx-auto px-4 py-8">
        <form action="" method="post" class="flex justify-end mb-4">
            
        </form>

        <div class="max-w-xl mx-auto bg-blue-200 rounded-xl shadow-md overflow-hidden">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">My Profile</h2>

                <div class="flex flex-col items-center mb-6">
        <img class="profile-img h-32 w-32 border-4 border-blue-200 mx-auto mb-4" src="images/p1.png" alt="Profile Image">
                    <h3 class="mt-4 text-2xl font-semibold text-gray-700"><?php echo $row['username']; ?></h3>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-3 gap-4 items-center">
                        <span class="text-gray-600 font-medium">ID</span>
                        <span class="col-span-2 text-gray-800 bg-gray-100 p-2 rounded"><?php echo $row['id']; ?></span>
                    </div>

                    <div class="grid grid-cols-3 gap-4 items-center">
                        <span class="text-gray-600 font-medium">First Name</span>
                        <span class="col-span-2 text-gray-800 bg-gray-100 p-2 rounded"><?php echo $row['firstname']; ?></span>
                    </div>

                    <div class="grid grid-cols-3 gap-4 items-center">
                        <span class="text-gray-600 font-medium">Last Name</span>
                        <span class="col-span-2 text-gray-800 bg-gray-100 p-2 rounded"><?php echo $row['lastname']; ?></span>
                    </div>

                    <div class="grid grid-cols-3 gap-4 items-center">
                        <span class="text-gray-600 font-medium">Username</span>
                        <span class="col-span-2 text-gray-800 bg-gray-100 p-2 rounded"><?php echo $row['username']; ?></span>
                    </div>

                    <div class="grid grid-cols-3 gap-4 items-center">
                        <span class="text-gray-600 font-medium">Password</span>
                        <span class="col-span-2 text-gray-800 bg-gray-100 p-2 rounded"><?php echo str_repeat('.', strlen($row['password'])); ?></span>
                    </div>

                    <div class="grid grid-cols-3 gap-4 items-center">
                        <span class="text-gray-600 font-medium">Email</span>
                        <span class="col-span-2 text-gray-800 bg-gray-100 p-2 rounded"><?php echo $row['email']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
