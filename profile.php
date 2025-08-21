
<?php require 'Database.php' ;
require 'navbar.php';
if(!isset($_SESSION['login_user'])) {
    header("Location: LoginPage.php");
    exit();
}

$username = $_SESSION['login_user'];
$res = mysqli_query($conn, "SELECT * FROM student_tbl WHERE username='$username'");
$row = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
     <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .profile-img{
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body class="bg-blue-200">
    <div class="container mx-auto px-4 py-8">
        <form action="" method="post" class="flex justify-end mb-4">
            <!-- <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200" name="submit1">
                Edit Profile -->
    </button>
    </form>
     <div class="max-w-xl mx-auto bg-indigo-300 rounded-xl shadow-md overflow-hidden">
            <div class="p-8">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">My Profile</h2>
    <div class="flex flex-col items-center mb-8">
        <img class="profile-img h-32 w-32 border-4 border-blue-200 mx-auto mb-4" src="images/p2.png" alt="Profile Image">

        <h3 class="mt-4 text-2xl font-semibold text-gray-700">
            <?php  if(isset($_SESSION['login_user'])){ ?>
                <?php echo $row['username']; ?>
                        <?php } ?>
                    </h3>
                </div>

<div class="flex items-center justify-center bg-gray-50">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-xl">
        <div class="space-y-3">
            <div class="grid grid-cols-3 gap-4 items-center">
                <span class="text-gray-600 font-medium">ID</span>
                <span class="col-span-2 text-gray-800 bg-gray-200 p-2 rounded"><?php echo $row['id']; ?></span>
                </div>
            <div class="grid grid-cols-3 gap-4 items-center">
                <span class="text-gray-600 font-medium">First Name:</span>
                <span class="col-span-2 text-gray-800 bg-gray-200 p-2 rounded"><?php echo $row['firstname']; ?></span>
            </div>
                <div class="grid grid-cols-3 gap-4 items-center">
                <span class="text-gray-600 font-medium">Last Name:</span>
                <span class="col-span-2 text-gray-800 bg-gray-200 p-2 rounded"><?php echo $row['lastname']; ?></span>
            </div>
                <div class="grid grid-cols-3 gap-4 items-center">
                <span class="text-gray-600 font-medium">UserName:</span>
                <span class="col-span-2 text-gray-800 bg-gray-200 p-2 rounded"><?php echo $row['username']; ?></span>
            </div>
                <div class="grid grid-cols-3 gap-4 items-center">
                <span class="text-gray-600 font-medium">Password:</span>
                <span class="col-span-2 text-gray-800 bg-gray-200 p-2 rounded"><?php echo str_repeat('.', strlen($row['password'])); ?></span>
            </div>
                <div class="grid grid-cols-3 gap-4 items-center">
                <span class="text-gray-600 font-medium">Email:</span>
                <span class="col-span-2 text-gray-800 bg-gray-200 p-2 rounded"><?php echo $row['email']; ?></span>
            </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</body>
</html>



              