<?php require 'Database.php';
require 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<main class="flex-grow flex items-center justify-center mt-32"> 
    <section class="w-full max-w-md">
        <div class="bg-blue-100 shadow-lg rounded-lg overflow-hidden w-3xl">
            <div class="px-6 py-6">
        <h2 class="text-2x1 font-bold  text-red-600 mb-6">If you have any query or suggestions please comment below.</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <div>
            <label for ="comment" class="block text-sm font-medium text-gray-700 mb-1">COMMENT</label>
            <input type="text" name="comment" placeholder="Write something..." class="w-full px-4 py-2 border  border-gray-300 rounded-b-md 
            focus:outline-none focus:ring-2 focus:ring-blue-500" required="">
        </div>
        </div>
        <div class="pt-2">
            <button type="submit" name="comment"
            class="w-full bg-blue-600 text-white py-2 px-3 rounded-md hover:bg-orange-400 transition duration-300
                focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">COMMENT</button>
        </div>
    </form>
   
    <br><br>
    <div class="scroll">
     <?php
        if(isset($_POST['submit'])){
                $comment = $_POST['comment']; 
    
        $sql = "INSERT INTO comments (username, comment) VALUES ('$_SESSION[login_user]', '$comment')";
                if(mysqli_query($conn, $sql)) {
        }
        }
         ?>
    </div>
    </div>
</body>
</html>
