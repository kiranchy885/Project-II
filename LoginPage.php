<?php
session_start();
require 'Database.php';
require 'header.html';
$error = "";

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $userType = $_POST['user'];

    if ($userType == 'admin') {
        $sql = "SELECT * FROM admin_tbl WHERE username='$username' AND password='$password'";
        $redirect = 'AdminMyprofile.php';
    } else {
        $sql = "SELECT * FROM student_tbl WHERE username='$username' AND password='$password'";
        $redirect = 'profile.php';
    }

    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if ($count == 0) {
        $error = "The username and password don't match.";
    } else {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['login_user'] = $username;
        $_SESSION['pic'] = $row['pic'];
        echo "<script>window.location='$redirect';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Library System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-indigo-950 min-h-screen flex items-center justify-center">
<main class="flex-grow flex items-center justify-center mt-32 mb-24"> 
    <div class="bg-indigo-300 bg-opacity-80 text-black p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-3xl font-bold text-center mb-4">Library Management System</h1>
        <h2 class="text-xl text-center font-bold mb-6"> Login Form</h2>

        <?php if (!empty($error)) { ?>
            <div class="bg-red-500 text-white text-center px-4 py-2 rounded mb-4">
                <strong><?php echo $error; ?></strong>
            </div>
        <?php } ?>

        <form method="POST" action="">
            <div class="mb-4">
                <p class="font-semibold text-2xl">Login as:</p>
                <label class="mr-4 font-bold">
                    <input type="radio" name="user" value="admin" required class="mr-1" checked>
                    Admin
                </label>
                <label class= "font-bold">
                    <input type="radio" name="user" value="student" required class="mr-1">
                    Student
                </label>
            </div>

            <div class="mb-4">
                <input type="text" name="username" placeholder="Username" required
                       class="w-full px-3 py-2 rounded bg-gray-100 text-black focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <input type="password" name="password" placeholder="Password" required
                       class="w-full px-3 py-2 rounded bg-gray-100 text-black focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <input type="submit" name="submit" value="Login"
                       class="w-full bg-blue-400 text-black font-semibold py-2 px-4 rounded hover:bg-yellow-500 cursor-pointer">
            </div>

            <div class="mt-6 text-center text-sm">
                <a href="UpdatePassword.php" class="text-black hover:underline">Forgot password?</a><br>
                New to this website?
                <a href="Registration.php" class="text-red-600 hover:underline">Sign Up</a>
            </div>
        </form>
    </div>

</body>
</html>