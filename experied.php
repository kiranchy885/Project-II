<?php require 'Database.php'; require 'experied.html'; require 'navbar.php';
session_start();
// require 'navbar.php';
?>
<body>
    <!-- ________________________sidenav____________________-->
<br><br><br><br>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div style="color: white; margin-left: 60px; font-size: 20px;">
  <?php
     if (isset($row) && isset($row['pic'])) {
      echo "<img class='img-circle profile_img' height=120 width=120 src='images/{$row['pic']}'>";
      echo "</br></br>";
    }
    if(isset($_SESSION['login_user'])){
    echo "Welcome ".$_SESSION['login_user'];
  }
?>
  </div>
  <a href="AddBook.php">Add Books</a>
  <a href="request.php">Book Request</a>
  <a href="issue_info.php">Issue Information</a>
  <a href="experied.php">Experied List<a>
</div>

<div id="main">
  <br><br><br>
  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
  document.body.style.backgroundColor= "rgba(0,0,0,0.4)";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.body.style.backgroundColor= "white";
}
</script>

<?php
    $user = $_GET['uname'];
    $id = $_GET['bid'];
      ?>
<div class="container" style="width: 80%;">
    <?php
    if(isset($_SESSION['login_user'])){
    ?>
    <div style="float: left; padding: 25px;">
    <button class="btn btn-default">RETURNED</button>
    <button class="btn btn=default">EXPERIED</button>
    </div>
    <div class="srch">
    <br><br><br>
    <div class="container">
    <form method="post" action="approve.php" name="form1" id="submit">
      <input type="text" id="username" name="username" class="form-control" placeholder="Username" required=""><br>
      <input type="text" id="BId" name="BId" class="form-control" placeholder="BID" required=""><br>
      <button class="btn btn-default" name="submit" type="submit"> Submit</button>
</form>
</div>
    <?php
    if(isset($_POST['submit'])){
        $var1='<p style="color:yellow; background-color:green;">RETURNED</p>';
      
    if (isset($_POST['username'], $_POST['bid'])) {
      // Assign the values to local variables
      $username = $_POST['username'];
      $bid = $_POST['bid'];  
    mysqli_query($conn,"UPDATE issue_book SET approve='$var1' where 
    username='$_POST[username]' and bid='$_POST[bid]' ");
    }
  }
}
    ?>
    <h3 style="text-align: center;">Date experied list </h3><br>
    <?php
    $c=0;
    if(isset($_SESSION['login_user'])){
        $var='<p style="color:yellow; background-color:red;">EXPERIED</p>';
        $sql="SELECT student_tbl.username, student_tbl.roll,books.BookId, books.BookName, books.Authors, books.Edition,approve,issue,issue_book.returnn FROM student_tbl 
            INNER JOIN issue_book ON student_tbl.username = issue_book.username 
            INNER JOIN books ON issue_book.bid = books.BookId
            WHERE issue_book.approve !='' and issue_book.approve !='Yes' ORDER By 'issue_book','returnn' ASC";

            $res=mysqli_query($conn, $sql);
             if ($res && mysqli_num_rows($res) > 0) {
            }
    }   
            echo "<table class='table table-border table-hover'>";
            echo "<tr style='background-color: white; text-align: center;'>";

            echo "<th>"; echo"Username"; echo "</th>";
            echo "<th>"; echo"Roll No"; echo "</th>";
            echo "<th>"; echo"BookId"; echo "</th>";
            echo "<th>"; echo"Book Name"; echo "</th>";
            echo "<th>"; echo"Authors Name"; echo "</th>";
            echo "<th>"; echo"Edition"; echo " </th>";
            echo "<th>"; echo"Status"; echo "</th>";
            echo "<th>"; echo"Issue Date"; echo"</th>";
            echo "<th>"; echo"Return Date"; echo "</th>";
            echo "</tr>";
            echo "</table>";

            // echo "<div class='scroll'>";
            echo "<table class='table table-border table-hover'>";
            while ($row = mysqli_fetch_assoc($res)) {
              echo "<tr>";
              echo "<td>" . $row['username'] . "</td>";
              echo "<td>" . $row['roll'] . "</td>";
              echo "<td>" . $row['BookId'] . "</td>";
              echo "<td>" . $row['BookName'] . "</td>";
              echo "<td>" . $row['Authors'] . "</td>";
              echo "<td>" . $row['Edition'] . "</td>";
              echo "<td>" . $row['approve'] . "</td>";
              echo "<td>" . $row['issue'] . "</td>";
              echo "<td>" . $row['returnn'] . "</td>";
              echo "</tr>";
        
        }
          echo "</table>";
 
    ?>
</div>
</body>
</html>