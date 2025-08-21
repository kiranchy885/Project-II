<?php
include("Database.php");

// Verify connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
$conn->set_charset("utf8mb4");

if (isset($_POST['input'])) {

    $input = trim(mysqli_real_escape_string($conn, $_POST['input']));
    
    $query = "SELECT BookId, BookName, Authors, Edition, 
                     Quantity, Status, Program FROM books WHERE BookName LIKE '%$input%' 
                 OR Program LIKE '%$input%'
                 OR BookId LIKE '%$input%' ORDER BY BookName LIMIT 10";
    
   
    error_log("Search Query: " . $query);
    
    $result = $conn->query($query);
    
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    
    if ($result->num_rows > 0) {
        echo "<div class='overflow-x-auto rounded-lg shadow-md mb-6'>";
        echo "<table class='min-w-full divide-y divide-gray-200'>";
        echo "<thead class='bg-pink-500 text-white'>";
        echo "<tr>";
        echo "<th class='px-6 py-3 text-left text-xs font-medium uppercase tracking-wider'>ID</th>";
        echo "<th class='px-6 py-3 text-left text-xs font-medium uppercase tracking-wider'>Book Name</th>";
        echo "<th class='px-6 py-3 text-left text-xs font-medium uppercase tracking-wider'>Authors</th>";
        echo "<th class='px-6 py-3 text-left text-xs font-medium uppercase tracking-wider'>Edition</th>";
        echo "<th class='px-6 py-3 text-left text-xs font-medium uppercase tracking-wider'>Quantity</th>";
        echo "<th class='px-6 py-3 text-left text-xs font-medium uppercase tracking-wider'>Status</th>";
        echo "<th class='px-6 py-3 text-left text-xs font-medium uppercase tracking-wider'>Program</th>";
  
        echo "</tr>";
        echo "</thead>";
        echo "<tbody class='bg-white divide-y divide-gray-200'>";
        
        while ($row = $result->fetch_assoc()) {
            $statusClass = $row['Status'] == 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
            
            echo "<tr class='hover:bg-gray-300 transition'>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['BookId']) . "</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap font-medium'>" . htmlspecialchars($row['BookName']) . "</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['Authors']) . "</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['Edition']) . "</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['Quantity']) . "</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>";
            echo "<span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full $statusClass'>";
            echo htmlspecialchars($row['Status']);
            echo "</span>";
            echo "</td>";
            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['Program']) . "</td>";
            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded'>";
        echo "<div class='flex'>";
        echo "</div>";
        echo "<div class='ml-3'>";
        echo "<h3 class='text-sm font-medium text-yellow-800'>No results found</h3>";
        echo "<div class='mt-2 text-sm text-yellow-700'>";
        echo "<p>No books found matching '<strong>" . htmlspecialchars($input) . "</strong>'.</p>";
        echo "<ul class='list-disc pl-5 mt-2 space-y-1'>";
        // echo "<li>Check your spelling</li>";
        echo "<li>Try different keywords or author names</li>";
        echo "</ul>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
}
?>