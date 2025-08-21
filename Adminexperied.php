<?php 
require 'Database.php'; 
require 'AdminNavbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Welcome Section -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <?php if(isset($_SESSION['login_user'])): ?>
                    <h1 class="text-2xl font-bold text-gray-800">Welcome, <?php echo htmlspecialchars($_SESSION['login_user']); ?></h1>
                <?php endif; ?>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-4 mb-8">
            <form method="post" action="Adminapprove.php">
                <button name="submit2" type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                    RETURNED
                </button>
            </form>
            <form method="post" action="Adminapprove.php">
                <button name="submit3" type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                    EXPIRED
                </button>
            </form>
        </div>

        <!-- Search Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Approve Book Return</h2>
            <form method="post" action="Adminapprove.php" class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" class="mt-1 block w-full px-3 py-2 border border-gray-300 
                    rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Username" required>
                </div>
                <div>
                    <label for="BId" class="block text-sm font-medium text-gray-700">Book ID</label>
                    <input type="text" id="BId" name="bid" class="mt-1 block w-full px-3 py-2 border border-gray-300 
                    rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="BID" required>
                </div>
                <button type="submit" name="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md 
                shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2
               focus:ring-indigo-500">
                    Submit
                </button>
            </form>
        </div>

        <!-- Book List Section -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-2xl font-semibold text-gray-800 text-center">Date Expired List</h3>
            </div>
            
            <?php
            $c = 0;
            if(isset($_SESSION['login_user'])){
                $return = '<span class="px-2 py-1 bg-green-600 text-white rounded-md">RETURNED</span>';
                $expired = '<span class="px-2 py-1 bg-red-600 text-white rounded-md">EXPIRED</span>';

                if(isset($_POST['submit2'])){
                    $sql = "SELECT student_tbl.username, student_tbl.contact, books.BookId, books.BookName, books.Authors, books.Edition, 
                    approve, issue, issue_book.returnn FROM student_tbl 
                            INNER JOIN issue_book ON student_tbl.username = issue_book.username 
                            INNER JOIN books ON issue_book.bid = books.BookId
                            WHERE issue_book.approve = '$return' ORDER BY issue_book.returnn ASC";
                }
                else if(isset($_POST['submit3'])){
                    $sql = "SELECT student_tbl.username, student_tbl.contact, books.BookId, books.BookName, books.Authors, books.Edition, approve, issue, issue_book.returnn 
                            FROM student_tbl 
                            INNER JOIN issue_book ON student_tbl.username = issue_book.username 
                            INNER JOIN books ON issue_book.bid = books.BookId
                            WHERE issue_book.approve = '$expired' ORDER BY issue_book.returnn ASC";
                }
                else {
                    $sql = "SELECT student_tbl.username, student_tbl.contact, books.BookId, books.BookName, books.Authors, books.Edition, approve, issue, issue_book.returnn 
                            FROM student_tbl 
                            INNER JOIN issue_book ON student_tbl.username = issue_book.username 
                            INNER JOIN books ON issue_book.bid = books.BookId
                            WHERE issue_book.approve != '' AND issue_book.approve != 'Yes' ORDER BY issue_book.returnn ASC";
                }

                $res = mysqli_query($conn, $sql);
                
                if ($res && mysqli_num_rows($res) > 0) {
                    echo '<div class="overflow-x-auto">';
                    echo '<table class="min-w-full divide-y divide-gray-200">';
                    echo '<thead class="bg-blue-500">';
                    echo '<tr>';
                    echo '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Username</th>';
                    echo '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Contact</th>';
                    echo '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Book ID</th>';
                    echo '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Book Name</th>';
                    echo '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Authors</th>';
                    echo '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Edition</th>';
                    echo '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Status</th>';
                    echo '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Issue Date</th>';
                    echo '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Return Date</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody class="bg-white divide-y divide-gray-200">';

                    while ($row = mysqli_fetch_assoc($res)) {
                        echo '<tr class="hover:bg-gray-50">';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['username']) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['contact']) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['BookId']) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['BookName']) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['Authors']) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['Edition']) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm">' . str_replace(
                        ['<p style="color:yellow; background-color:green;">RETURNED</p>', '<p style="color:yellow; background-color:red;">EXPIRED</p>'],
                        [$return, $expired],
                            $row['approve']
                        ) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['issue']) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['returnn'] ?? '') . '</td>';
                        echo '</tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                } else {
                    echo '<div class="p-6 text-center text-gray-500">';
                    echo '<p class="text-lg">No records found</p>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</body>
</html>