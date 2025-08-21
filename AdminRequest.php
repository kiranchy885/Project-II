<?php require 'Database.php'; 
require 'AdminNavbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Requests</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Welcome Message -->
            <div class="mb-8 text-center">
                <?php if(isset($_SESSION['login_user'])): ?>
                    <h1 class="text-3xl font-bold text-gray-800">Welcome, <?php echo $_SESSION['login_user']; ?></h1>
                <?php endif; ?>
            </div>

            <!-- Search Form -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Approve Book Request</h2>
                <form method="get" action="Adminapprove.php" class="space-y-4">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" id="username" name="uname" class="w-full px-4 py-2 border border-gray-300 rounded-md 
                        focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Username" required>
                    </div>
                    <div>
                        <label for="BookName" class="block text-sm font-medium text-gray-700 mb-1">Book Nmae</label>
                        <input type="text" id="BookName" name="bookname" class="w-full px-4 py-2 border border-gray-300 rounded-md 
                        focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="BookName" required>
                    </div>
                    <!-- <div>
                        <label for="Category" class="block text-sm font-medium text-gray-700 mb-1">Book category</label>
                        <input type="text" id="Category" name="bookname" class="w-full px-4 py-2 border border-gray-300 rounded-md 
                        focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="BookCategory" required>
                    </div> -->
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md 
                    transition duration-300">Approved</button>
                </form>
            </div>

            <!-- Request List -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <h3 class="text-xl font-semibold text-center bg-indigo-300 text-black p-4 ">Book Requests</h3>
                
                <?php
                if(isset($_SESSION['login_user'])){
                $sql = "SELECT student_tbl.username, student_tbl.contact,books.BookId, books.BookName, books.Authors, books.Edition, books.Status, books.Category, books.Program FROM student_tbl 
                INNER JOIN issue_book ON student_tbl.username = issue_book.username 
                INNER JOIN books ON issue_book.bookname = books.BookName
                -- INNER JOIN books ON issue_book.category = books.Category
                WHERE issue_book.approve ='pending'; ";
                $res = mysqli_query($conn,$sql);
            
                if(mysqli_num_rows($res) == 0) {
                echo "<h2><b>";
                echo "There's no pending request";
                echo "</h2></b>";
                }
                    
            }
            echo '<div class="overflow-x-auto">';
            echo '<table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">';
            echo '<thead class="bg-indigo-300">';
            echo '<tr class="text-center">';
            echo '<th class="py-3 px-4 border-b font-medium text-gray-700">Username</th>';
            echo '<th class="py-3 px-4 border-b font-medium text-gray-700">Contact</th>';
            echo '<th class="py-3 px-4 border-b font-medium text-gray-700">BookId</th>';
            echo '<th class="py-3 px-4 border-b font-medium text-gray-700">Book Name</th>';
            echo '<th class="py-3 px-4 border-b font-medium text-gray-700">Authors Name</th>';
            echo '<th class="py-3 px-4 border-b font-medium text-gray-700">Edition</th>';
            echo '<th class="py-3 px-4 border-b font-medium text-gray-700">Status</th>';
                echo '<th class="py-3 px-4 border-b font-medium text-gray-700">Category</th>';
            echo '<th class="py-3 px-4 border-b font-medium text-gray-700">Program</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody class="divide-y divide-gray-200">';

            // Your while loop for table rows would go here
            while ($row = mysqli_fetch_assoc($res)) {
                echo '<tr class="hover:bg-gray-50 text-center">';
                echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['username']).'</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['contact']).'</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['BookId']).'</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['BookName']).'</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['Authors']).'</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['Edition']).'</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['Status']).'</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['Category']).'</td>';

                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['Program']).'</td>';

                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            ?>
            <?php
    if(isset($_POST['submit'])){
    $_SESSION['username']=$_POST['username'];
      $_SESSION['BookName']=$_POST['BookName'];
      ?>
      <script type="text/javascript">
      window.location="approve.php"
      </script>
        <?php
      }
            echo '</div>';
                ?>
            </div>
        </div>
    </div>
</body>
</html>