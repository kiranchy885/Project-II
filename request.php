<?php 
require 'Database.php';
// require 'Request.html';
require 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Requests</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> -->
</head>
<body class="bg-gray-100">
    </header>

    <div class="container mx-auto px-4 py-12">
        <div class="mt-12">
            <?php
            if (isset($_SESSION['login_user'])) {
    $q = mysqli_query($conn, "SELECT bookname, approve, issue, returnn FROM issue_book WHERE username='{$_SESSION['login_user']}'");

    if (mysqli_num_rows($q) == 0) {
        echo "<div class='bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded'>There's no pending request</div>";
    } else {
        echo "<div class='overflow-x-auto'>";
        echo "<table class='min-w-full bg-white rounded-lg overflow-hidden shadow-md'>";
        echo "<thead class='bg-indigo-300 text-black'>";
        echo "<tr>";
        echo "<th class='py-3 px-4 text-left'>BookName</th>";
        //  echo "<th class='py-3 px-4 text-left'>Category</th>";
        echo "<th class='py-3 px-4 text-left'>Status</th>";
        echo "<th class='py-3 px-4 text-left'>Issue Date</th>";
        echo "<th class='py-3 px-4 text-left'>Return Date</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody class='divide-y divide-gray-200'>";

        while ($row = mysqli_fetch_assoc($q)) {
            $statusClass = ($row['approve'] == 'Approved') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';

            echo "<tr class='hover:bg-gray-100'>";
            echo "<td class='py-3 px-4'>" . $row['bookname'] . "</td>";
            // echo "<td class='py-3 px-4'>" . $row['category'] . "</td>";

            echo "<td class='py-3 px-4'><span class='px-2 py-1 rounded-full text-xs font-semibold $statusClass'>" . $row['approve'] . "</span></td>";
            echo "<td class='py-3 px-4'>" . $row['issue'] . "</td>";
            echo "<td class='py-3 px-4'>" . $row['returnn'] . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }
}
     ?>
        </div>
    </div>
</body>
</html>