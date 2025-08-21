<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Library Book Recommendations</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-indigo-950">
    <div class="max-w-5xl mx-auto mt-16 px-4">
        <h1 class="text-3xl font-bold text-center text-blue-300 mb-6">Recommended Books for You</h1>
        <?php
        require 'Database.php';
        
        // For testing - replace with actual logged-in user from session
        $username = 'testuser'; // $_SESSION['username'];
        
        function getBorrowedBooks($conn, $username) {
            $sql = "SELECT bookname FROM issue_book WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $books = [];
            while ($row = $result->fetch_assoc()) {
                $books[$row['bookname']] = true;
            }
            return $books;
        }
        
        function getUserCategories($conn, $username) {
            $sql = "SELECT DISTINCT b.Category 
                    FROM issue_book ib 
                    JOIN books b ON ib.bookname = b.BookName 
                    WHERE ib.username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $categories = [];
            while ($row = $result->fetch_assoc()) {
                $categories[$row['Category']] = true;
            }
            return $categories;
        }
        
        function getRecommendations($conn, $username, $limit = 6) {
            $borrowedBooks = getBorrowedBooks($conn, $username);
            $userCategories = getUserCategories($conn, $username);
            
            // If no borrowing history, recommend popular books
            if (empty($userCategories)) {
                $sql = "SELECT b.* FROM books b 
                        LEFT JOIN issue_book ib ON b.BookName = ib.bookname AND ib.username = ?
                        WHERE ib.bookname IS NULL
                        GROUP BY b.BookName
                        ORDER BY COUNT(ib.bookname) DESC 
                        LIMIT ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $username, $limit);
                $stmt->execute();
                return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            }
            
            // Get books from user's categories that they haven't borrowed
            $categoryNames = array_keys($userCategories);
            $placeholders = implode(',', array_fill(0, count($categoryNames), '?'));
            $types = str_repeat('s', count($categoryNames));
            
            $sql = "SELECT b.* FROM books b
                    LEFT JOIN issue_book ib ON b.BookName = ib.bookname AND ib.username = ?
                    WHERE b.Category IN ($placeholders)
                    AND ib.bookname IS NULL
                    ORDER BY RAND()
                    LIMIT ?";
            
            $stmt = $conn->prepare($sql);
            
            // Bind parameters - username first, then categories, then limit
            $params = array_merge([$username], $categoryNames, [$limit]);
            $types = 's' . $types . 'i'; // username (string) + categories (strings) + limit (int)
            
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        
        $recommendedBooks = getRecommendations($conn, $username, 6);
        
        if (empty($recommendedBooks)) {
            echo "<p class='text-center text-gray-400 py-10'>No recommendations available. You may have borrowed all books in your preferred categories.</p>";
        } else {
            echo "<div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6'>";
            foreach ($recommendedBooks as $book) {
                echo "<div class='bg-gray-800 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300 hover:bg-gray-700'>
                    <div class='p-4'>
                        <h2 class='text-lg font-semibold text-white mb-2'>{$book['BookName']}</h2>
                        <p class='text-gray-300 mb-1'><span class='font-medium text-blue-300'>Author:</span> {$book['Authors']}</p>
                        <p class='text-gray-300'><span class='font-medium text-blue-300'>Category:</span> {$book['Category']}</p>
                    </div>
                </div>";
            }
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>