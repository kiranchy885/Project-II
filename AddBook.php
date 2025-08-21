<?php require 'Database.php';
require 'AdminNavbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adding Books</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<div class="min-h-screen bg-indigo-950 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Add New Book</h2>
        <form class="space-y-4" action="" method="post" id="submit">
            <div>
                <input type="text" id="BookId" name="BookId" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Book ID" required>
            </div>
            
            <div>
                <input type="text" id="BookName" name="BookName" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Book Name" required>
            </div>
            
            <div>
                <input type="text" id="Authors" name="Authors" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Authors Name" required>
            </div>
            
            <div>
                <input type="text" id="Edition" name="Edition" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Edition" required>
            </div>
            
            <div>
                <input type="text" id="Quantity" name="Quantity" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Quantity" required>
            </div>
            
            <div>
                <input type="text" id="Status" name="Status" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Status" required>
            </div>
            <div>
                <input type="text" id="Category" name="Category" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Category" required>
            </div>
            <div>
                <input type="text" id="Program" name="Program" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Program" required>
            </div>

            <button type="submit" name="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                Add Book
            </button>
        </form>
    </div>
</div>
 <?php
 if(isset($_POST['submit'])){

    $BookId= $_POST['BookId'];
    $BookName= $_POST['BookName'];
    $Authors= $_POST['Authors'];
    $Edition= $_POST['Edition'];
    $Quantity= $_POST['Quantity'];
    $Status= $_POST['Status'];
    $Category= $_POST['Category'];
    $Program= $_POST['Program'];

    $sql = "INSERT INTO books Values('".$BookId ."','". $BookName."','".$Authors ."','". $Edition ."','". $Quantity ."','". $Status ."','".$Category ."','".$Program ."')"; 
    if ($conn->query($sql) === TRUE){
        echo " Book Added. ";
     }else {
        echo "Error: " . $sql . "<br>". $conn->error;
     }
 }
 
?>
</body>
</html>