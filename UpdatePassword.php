<?php
require 'Database.php' ;
require 'Navbar copy.php';

if ($_SERVER['REQUEST_METHOD']== "POST"){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $insert = "UPDATE admin_tbl SET username='".$username."', email='" .$email."',
    password='".$password."' WHERE username='".$username."'" ;

    if ($conn->query($insert) === TRUE) {
        echo "Password updated successfully";
    } else {
        echo "Error updating password into table: " . $conn->error;
    }
    
    $conn->close();
    ?>
    <script type="text/javascript">
      window.location = "LoginPage.php";
      alert("Password Updated Successfully.");
    </script>
    <?php
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-indigo-950">

    <main class="min-h-screen flex items-center justify-center pt-24 pb-12 px-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-indigo-300 py-4 px-6">
                <h2 class="text-2xl font-bold text-white text-center">Update Your Password</h2>
            </div>
            
            <form id="myForm" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="p-6 space-y-6">
                <div>
                    <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                    <input type="text" id="username" name="username" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Enter your username" required>
                </div>
                
                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Enter your email" required>
                </div>
                
                <div>
                    <label for="password" class="block text-gray-700 font-medium mb-2">New Password</label>
                    <input type="password" id="password" name="password" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Enter new password" required>
                </div>
                
                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md transition duration-300">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </main>

<script>
    function validateForm() {
        var username = document.forms["myForm"]["username"].value;
        var email = document.forms["myForm"]["email"].value;
        var password = document.forms["myForm"]["password"].value;

        if (username == "") {
            alert("Username must be filled out");
            return false;
        }
        if (email == "") {
            alert("Email must be filled out");
            return false;
        }
        if (password == "") {
            alert("Password must be filled out");
            return false;
        }
        return true;
    }
</script>
</body>
</html>