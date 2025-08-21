<?php 
require 'Database.php';
require 'AdminNavbar.php';
session_start();

if (!isset($_SESSION['login_user'])) {
  header("Location:LoginPage.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Approve Book</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden">
      <div class="p-8">
        <div class="text-center mb-6">
          <?php
          $user = $_GET['uname'];
          $bookname = $_GET['bookname'];
          ?>
          <h3 class="text-2xl font-bold text-gray-800">Approve Request from <?php echo htmlspecialchars($user); ?></h3>
        </div>

        <!-- Approval Form -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?uname=" . urlencode($user) . "&bookname=" . urlencode($bookname); ?>" method="post" class="space-y-4">
          <div>
            <label for="approve" class="block text-sm font-medium text-gray-700 mb-1">Approve Request</label>
            <select name="approve" id="approve" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
              <option value="" disabled selected>Select an option</option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>

          <div>
            <label for="issue" class="block text-sm font-medium text-gray-700 mb-1">Issue Date</label>
            <input type="date" name="issue" id="issue" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
          </div>

          <div>
            <label for="returnn" class="block text-sm font-medium text-gray-700 mb-1">Return Date</label>
            <input type="date" name="returnn" id="returnn" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
          </div>

          <input type="hidden" name="bookname" value="<?php echo htmlspecialchars($bookname); ?>">
          <input type="hidden" name="user" value="<?php echo htmlspecialchars($user); ?>">

          <div class="pt-4">
            <button type="submit" name="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
              Submit Approval
            </button>
          </div>
        </form>
      </div>

      <?php
      if (isset($_POST['submit'])) {
          $approve = $_POST['approve'];
          $issue = $_POST['issue'];
          $returnn = $_POST['returnn'];
          $user = $_POST['user'];
          $category = $_POST['category'];
          $bookname = $_POST['bookname'];

          // 1. Approve request in issue_book
          $update = $conn->prepare("UPDATE issue_book SET approve = ?, issue = ?, returnn = ? WHERE username = ? AND bookname = ?");
          $update->bind_param("sssss", $approve, $issue, $returnn, $user, $bookname);
          $update->execute();

          // 2. Reduce book quantity and check availability
          $stmt = $conn->prepare("UPDATE books SET Quantity = Quantity - 1 WHERE BookName = ?");
          $stmt->bind_param("s", $bookname);
          $stmt->execute();

          // 3. Check if quantity is 0, set status to 'not-available'
          $checkQty = $conn->prepare("SELECT Quantity FROM books WHERE BookName = ?");
          $checkQty->bind_param("s", $bookname);
          $checkQty->execute();
          $qtyResult = $checkQty->get_result();
          $row = $qtyResult->fetch_assoc();

          if ($row && $row['Quantity'] == 0) {
              $conn->prepare("UPDATE books SET status='not-available' WHERE BookName = ?")->bind_param("s", $bookname)->execute();
          }
      ?>
        <script>
          alert("✅ Request Approved Successfully.");
          window.location = "AdminRequest.php";
        </script>
      <?php } ?>
    </div>
  </div>
</body>
</html>
