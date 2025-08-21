<?php 
require 'Database.php'; 
require 'AdminNavbar.php';
?>

<div class="mx-auto w-[900px] p-6 bg-white rounded-lg shadow-md mb-14">
    <h2 class="text-red-600 text-lg font-semibold mb-16">
        If you have any query or suggestions, please comment below.
    </h2>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="space-y-4">
        <input type="text" name="comment" placeholder="Write something..." 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

        <input type="submit" name="submit" value="Comment" 
            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 cursor-pointer">
    </form>
</div>


    <div class="scroll">
        <?php
        
            $query = "SELECT * FROM comments ORDER BY username DESC";
            $res = mysqli_query($conn, $query);

            if (!$res) {
                echo "<p style='color:red;'>Error fetching comments: " . mysqli_error($conn) . "</p>";
            } else {
             
                echo '<div class="flex justify-center">';
                echo '<div class="overflow-x-auto">';
                echo '<table class="w-[900px] bg-white border border-gray-300 rounded-lg shadow-md">';
                echo '<thead class="bg-blue-400 text-white">';
                echo '<tr>';
                echo '<th class="px-6 py-3 text-left text-sm font-semibold uppercase">Username</th>';
                echo '<th class="px-6 py-3 text-left text-sm font-semibold uppercase">Comment</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody class="text-gray-700">';

                while ($row = mysqli_fetch_assoc($res)) {
                    echo '<tr class="border-b border-gray-200 hover:bg-blue-50 transition duration-150">';
                    echo '<td class="px-6 py-4">' . htmlspecialchars($row['username']) . '</td>';
                    echo '<td class="px-6 py-4">' . htmlspecialchars($row['comment']) . '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                }
                ?>

    </div>
</div>
</body>
</html>
