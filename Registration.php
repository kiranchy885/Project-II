<?php require 'Database.php'; require 'Registration.html';
 ?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HTML Registration Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
<main class="flex-grow flex items-center justify-center mt-32"> 
    <section class="w-full max-w-md">
        <div class="bg-indigo-300 shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-6">  
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6"> Registration Form</h2>
                    
                <form name="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="login" onsubmit="return validateForm()">
                <div class="space-y-4">
                <!-- <input type="text" name="contact" required> -->
                    <select name="userType" required>
                    <option value="student">Student</option>
                        <option value="admin">Admin</option>
                </select>
                <div>
                    <label for ="id" class="block text-sm font-medium text-gray-700 mb-1">ID</label>
                    <input type="text" id="id" name="id" placeholder="Enter your id" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-b-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required="">
                </div>

                <div>
                    <label for ="firstname" class="block text-sm font-medium text-gray-700 mb-1">FrstName</label>
                    <input type="text" id="firstname" name="firstname" placeholder="First Name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-b-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required="">
                </div>
                <div>
                    <label for ="lastname" class="block text-sm font-medium text-gray-700 mb-1">LastName</label>
                    <input type="text" name="lastname" placeholder="Last Name" class="w-full px-4 py-2 border border-gray-300 rounded-b-md 
                    focus:outline-none focus:ring-2 focus:ring-blue-500" required="">
                </div>
                <div>
                    <label for ="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" placeholder="username" class="w-full px-4 py-2 border border-gray-300 rounded-b-md 
                    focus:outline-none focus:ring-2 focus:ring-blue-500" required="">
                </div>
                <div>
                    <label for ="contact" class="block text-sm font-medium text-gray-700 mb-1">Conatct No</label>
                    <input type="text" name="contact" placeholder="Contact Number" class="w-full px-4 py-2 border border-gray-300 rounded-b-md 
                    focus:outline-none focus:ring-2 focus:ring-blue-500" required="">
                </div> 
                <div>
                    <label for ="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" placeholder="password" class="w-full px-4 py-2 border border-gray-300 rounded-b-md 
                    focus:outline-none focus:ring-2 focus:ring-blue-500" required="">
                </div>
                <div>
                    <label for ="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="text" name="email" placeholder="Email" class="w-full px-4 py-2 border border-gray-300 rounded-b-md 
                    focus:outline-none focus:ring-2 focus:ring-blue-500" required="">  
                </div>
                <div class="pt-2">
                    <input type="submit" value="Sign Up"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 
                    focus:outline-none focus:ring-blue-500 focus:ring-offset-2">
                </div>

                <div class="text-center text-sm text-gray-600">
                    <p> Already have a account? <a href="student-login.php" class="text-blue-600 hover:underline" >Sign Up </a></p>
                </div>
            </div> 
        </form>
    </div>
    </div>
</section>
</body>
</main>

   <?php
require 'Database.php'; // Make sure this connects to $conn

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate all required fields
    if (
        isset($_POST['id'], $_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['password'], $_POST['contact'], $_POST['email'], $_POST['userType'])
    ) {
        // Fetch values from form
        $id = $_POST['id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $contact = $_POST['contact'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $userType = $_POST['userType']; // new: admin or student

        // Choose correct table based on user type
        if ($userType === 'admin') {
            $sql = "INSERT INTO admin_tbl (id, firstname, lastname, username, contact, password, email) 
                    VALUES ('$id', '$firstname', '$lastname', '$username', '$contact', '$password', '$email')";
        } else {
            $sql = "INSERT INTO student_tbl (id, firstname, lastname, username, contact, password, email) 
                    VALUES ('$id', '$firstname', '$lastname', '$username', '$contact', '$password', '$email')";
        }

        if ($conn->query($sql) === TRUE) {
            echo '<p class="text-white font-semibold mt-4">✅ Registration successfully done.</p>';
        } else {
            echo '<p class="text-red-600 font-semibold mt-4"> Error: ' . $sql . "<br>" . $conn->error .'</p>';
        }
    } else {
        echo " Missing required fields.";
    }
}
?>
</body>
</html>