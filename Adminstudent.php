<?php 
require 'Database.php'; 
require 'AdminNavbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-indigo-950">
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-8">
        </div>

        <!-- Search Bar -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="relative max-w-md mx-auto">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input 
                    type="text" 
                    id="search" 
                    name="search" 
                    placeholder="Search students..." 
                    required
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    onkeyup="searchStudent()"
                >
            </div>
        </div>

        <!-- Student List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 text-center">List of Students</h2>
            </div>
            
            <div id="search_results" class="overflow-x-auto">
                <?php
                $studentretrive = "SELECT * FROM student_tbl";
                $result = $conn->query($studentretrive);

                if ($result->num_rows > 0) {
                    echo '<table class="min-w-full divide-y divide-gray-200">';
                    echo '<thead class="bg-blue-500">';
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
                        echo '<tr class="hover:bg-gray-200">';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['firstname']) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['lastname']) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['username']) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['contact']) . '</td>';
                        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . htmlspecialchars($row['email']) . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo '<div class="p-6 text-center text-gray-500">';
                    echo '<p class="text-lg font-medium">No students found</p>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <script>
    function searchStudent() {
        var searchValue = document.getElementById('search').value;
        
        if(searchValue.length == 0) {
            // If search field is empty, show all students
            searchValue = 'all';
        }
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'Adminsearch_student.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        
        xhr.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                document.getElementById('search_results').innerHTML = this.responseText;
            }
        };
        
        xhr.send('search=' + searchValue);
    }
    </script>
</body>
</html>