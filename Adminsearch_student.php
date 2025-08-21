<?php
require 'Database.php';

if(isset($_POST['search'])) {
    $searchVal = $_POST['search'];
    $limit = 10; // Set the maximum number of results to display
    
    if($searchVal == 'all') {
        $query = "SELECT * FROM student_tbl LIMIT $limit";
    } else {
        $query = "SELECT * FROM student_tbl WHERE 
                 username LIKE '%$searchVal%' OR 
                 contact LIKE '%$searchVal%' 
                 LIMIT $limit";
    }
    
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        echo '<div class="overflow-x-auto rounded-lg shadow border border-gray-200">';
        echo '<table class="min-w-full divide-y divide-gray-200">';
        echo '<thead class="bg-pink-500">';
        echo '<tr>';
        echo '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">First Name</th>';
        echo '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Last Name</th>';
        echo '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Username</th>';
        echo '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Contact</th>';
        echo '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Email</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody class="bg-white divide-y divide-gray-200">';
        
        while ($row = $result->fetch_assoc()) {
            echo '<tr class="hover:bg-gray-300 transition-colors duration-150">';
            echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['firstname']) . '</td>';
            echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['lastname']) . '</td>';
            echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['username']) . '</td>';
            echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['contact']) . '</td>';
            echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['email']) . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        
        // Show a message if results were limited
        if($result->num_rows == $limit && $searchVal != 'all') {
            echo '<div class="mt-4 p-3 bg-yellow-50 text-yellow-800 rounded-md border border-yellow-200">';
            echo '<p class="text-sm">Showing first '.$limit.' results. Try a more specific search for better results.</p>';
            echo '</div>';
        }
    } else {
        echo '<div class="mt-4 p-4 bg-blue-50 text-blue-800 rounded-md border border-blue-200 text-center">';
        echo '<p class="text-sm">No matching students found. Please search by username or roll number.</p>';
        echo '</div>';
    }
}
?>