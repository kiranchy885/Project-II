<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Library Book Recommendations</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-indigo-950">
    <div class="max-w-5xl mx-auto mt-10 px-4">
        <h1 class="text-3xl font-bold text-center text-blue-800 mb-6">Recommended Books for You</h1>
        <?php
        $_GET['username'] = 1; // Replace with actual logged-in user ID
        // include 'recommend.php';
        ?>
    </div>

<?php
require 'Database.php';

function getUserCategoryMatrix($conn) {
    $sql = "SELECT ib.username, b.Category 
            FROM issue_book ib 
            JOIN books b ON ib.bookname = b.BookName";
    $result = $conn->query($sql);  

    $matrix = [];
    while ($row = $result->fetch_assoc()) {
        $matrix[$row['username']][$row['Category']] = 1;
    }
    return $matrix;
}

function jaccardSimilarity($categoriesA, $categoriesB) {
    $intersection = count(array_intersect_key($categoriesA, $categoriesB));
    $union = count($categoriesA + $categoriesB);
    return $union === 0 ? 0 : $intersection / $union;
}

function getRecommendations($conn, $targetUsername, $limit = 5) {
    $categoryMatrix = getUserCategoryMatrix($conn);

    if (!isset($categoryMatrix[$targetUsername]) || count($categoryMatrix[$targetUsername]) === 0) {
        // No history fallback: most popular categories
        $sql = "SELECT b.* FROM books b 
                JOIN issue_book ib ON b.BookName = ib.bookname 
                GROUP BY b.Category 
                ORDER BY COUNT(*) DESC 
                LIMIT ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    $similarities = [];
    foreach ($categoryMatrix as $otherUser => $categories) {
        if ($otherUser == $targetUsername) continue;
        $similarities[$otherUser] = jaccardSimilarity($categoryMatrix[$targetUsername], $categories);
    }

    arsort($similarities);

    $targetCategories = $categoryMatrix[$targetUsername];
    $recommendedCategories = [];

    foreach ($similarities as $similarUser => $score) {
        if ($score <= 0) continue;

        foreach ($categoryMatrix[$similarUser] as $category => $val) {
            if (!isset($targetCategories[$category])) {
                $recommendedCategories[$category] = ($recommendedCategories[$category] ?? 0) + $score;
            }
        }
    }

    arsort($recommendedCategories);
    $recommendedCategoryNames = array_keys(array_slice($recommendedCategories, 0, $limit, true));

    if (empty($recommendedCategoryNames)) {
        // Fallback if no recommendations
        $sql = "SELECT * FROM books ORDER BY RAND() LIMIT ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Fetch books from recommended categories
//     $placeholders = implode(',', array_fill(0, count($recommendedCategoryNames), '?'));
//     $types = str_repeat('s', count($recommendedCategoryNames));
//     $sql = "SELECT * FROM books WHERE Category IN ($placeholders) ORDER BY RAND() LIMIT ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param($types . 'i', ...$recommendedCategoryNames, $limit);
//     $stmt->execute();
//     return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Fetch recommendations for the logged-in user
// $username = $_SESSION['username']; 
$recommendedBooks = getRecommendations($conn, $username, 6); // Get 6 recommendations

// Display books
if (empty($recommendedBooks)) {
    echo "<p class='text-center text-gray-500'>No recommendations available at this time.</p>";
} else {
    echo "<div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6'>";
    foreach ($recommendedBooks as $book) {
        echo "<div class='overflow-hidden hover:shadow-xl transition-shadow duration-300 bg-gray-800 rounded-lg'>
            <div class='p-4'>
                <h2 class='text-lg font-semibold text-white mb-2'>{$book['BookName']}</h2>
                <p class='text-white mb-1'><span class='font-medium'>Author:</span> {$book['Authors']}</p>
                <p class='text-white'><span class='font-medium'>Category:</span> {$book['Category']}</p>
            </div>
        </div>";
    }
    echo "</div>";
}
?>

</body>
</html>
