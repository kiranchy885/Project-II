<?php 
require 'Database.php';
require 'AdminNavbar.php';
if (!isset($_SESSION['login_user'])) {
    header("Location: LoginPage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Information</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Borrowed Books Information</h1>
            <div class="text-sm text-gray-600">
                Welcome, <?php echo htmlspecialchars($_SESSION['login_user']); ?>
            </div>
        </div>

        <?php
        $c = 0;
        if(isset($_SESSION['login_user'])){
            $sql = "SELECT student_tbl.username, student_tbl.contact, books.BookId, books.BookName, books.Authors, 
                    books.Edition, books.Status,books.Category issue_book.issue, issue_book.returnn 
                    FROM student_tbl 
                    INNER JOIN issue_book ON student_tbl.username = issue_book.username 
                    INNER JOIN books ON issue_book.bookname = books.BookName
                     INNER JOIN books ON issue_book.category = books.Category
                    WHERE issue_book.approve='Yes' ORDER BY issue_book.issue, issue_book.returnn ASC";

            $res = mysqli_query($conn, $sql);
           
            if(mysqli_num_rows($res) == 0) {
                echo '<div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
                        <p class="font-bold">No Records Found</p>
                        <p>There are currently no borrowed books.</p>
                      </div>';
            } else {
                echo '<div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-800">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Username</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Roll No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Book ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Book Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Authors</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Edition</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Issue Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Return Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">';
                
                while ($row = mysqli_fetch_assoc($res)) {
                    $date = date("y-m-d");
                    $isExpired = isset($row['returnn']) && $date > $row['returnn'];
                    
                    if ($isExpired) {
                        $c++; 
                        $var = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">EXPIRED</span>';
                        $update_sql = "UPDATE issue_book SET approve = 'Expired' WHERE returnn = '{$row['returnn']}' AND approve = 'Yes'";
                        mysqli_query($conn, $update_sql);
                    }
                    
                    echo '<tr class="'.($isExpired ? 'bg-red-50' : 'hover:bg-gray-50').'">';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['username']).'</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['contact']).'</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['BookId']).'</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['BookName']).'</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['Authors']).'</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['Edition']).'</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.htmlspecialchars($row['Status']).'</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">'.(isset($row['issue']) ? htmlspecialchars($row['issue']) : '').'</td>';
                    echo '<td class="px-6 py-4 whitespace-nowrap text-sm '.($isExpired ? 'text-red-600 font-bold' : 'text-gray-900').'">';
                    echo (isset($row['returnn']) ? htmlspecialchars($row['returnn']) : '');
                    if ($isExpired) {
                        echo ' <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">EXPIRED</span>';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
                
                echo '</tbody>
                            </table>
                        </div>
                    </div>';
            }
        }
        ?>
    </div>
</body>
</html>