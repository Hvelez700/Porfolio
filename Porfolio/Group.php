
<?php
// Start the session
session_start();


//check if user is logged in
if (isset($_SESSION['user_id'])) {
    echo $_SESSION['name'];
    
}//if not logged in redirect to login page
else{
    header("Location: Login.php");
    exit();
}

require_once 'db_connect.php';

$user_id = $_SESSION['user_id'];


//get user groups
//sql query to get groups for the logged-in user
$sql = "SELECT * FROM `_group_` WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);//prepare statement
$stmt->bindParam(':user_id', $_SESSION['user_id']);//bind user id
$stmt->execute();





?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register-style.css" type="text/css">
    <link rel="stylesheet" href="contacts_style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <title>My Groups</title>


    <style>
        .alert-container {
  margin: 20px 0;
}

.alert {
  position: relative;
  padding: 15px 40px 15px 15px; /* Extra padding on right for the X */
  margin-bottom: 10px;
  border-radius: 4px;
  font-family: Arial, sans-serif;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.alert-error {
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

.close-btn {
  position: absolute;
  top: 5px;
  right: 10px;
  background: none;
  border: none;
  font-size: 20px;
  font-weight: bold;
  cursor: pointer;
  color: inherit;
  opacity: 0.5;
}

.close-btn:hover {
  opacity: 1;
}


    </style>




</head>
<body>

<div class="container">
    <nav class="contact-info">
        <ul>
           <li><a href="Group.php">Groups</a></li>
            <li><a href="contacts.php">Contacts</a></li>
            <li><a href="Logout.php">Logout</a></li>
        </ul>
    </nav>
    <h1>My Groups</h1>
    <!-- <div class="search">
        <form action="#" methods="post">
            <input type="search" placeholder="search contacts">
            <button type="submit" name="search-submit">Search</button>

        </form>
    </div> -->

    <?php 
         if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
    <div class="alert-container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <span><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
                <button class="close-btn">&times;</button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <span><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
                <button class="close-btn">&times;</button>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>


    <table  class="info">
        <thead>
            <tr>
                <th>ID</th>
                <th>Group Name</th>
                <th>Action</th>
            </tr>
            <tbody>
              
                   
                    <!-- <td>Test name</td>
                    <td>
                    <a href="#" class="icon icon-edit" title="edit"></a>
                    <a href="#" class="icon icon-delete" title="delete"></a>
                    </td>
                </tr> -->
                    <?php 
                    //get groups from database
                     $sql = "SELECT * FROM `_group_` WHERE user_id = :user_id";
                     $stmt = $conn->prepare($sql);//prepare statement
                     $stmt->bindParam(':user_id', $_SESSION['user_id']);//bind user id
                     $stmt->execute();
                      

                        //process groups
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
                    {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                        echo '<td>';
                        echo "<a href=edit-group.php?id=" . htmlspecialchars($row['id']) . "  class='icon icon-edit' title='edit'></a>";
                        echo "<a href=delete.php?id=" . htmlspecialchars($row['id']) . "  class='icon icon-delete' title='delete'></a>";
                        echo "</td>";
                        echo '</tr>';
                        
                    }
                    ?>




            </tbody>

        </thead>
        
    </table>
    <div class="icon-add-container">
        <a href="add-group.php" class="icon icon-add" title="add group">
        <i class="fas fa-plus"></i>
    </a>
    </div>

</div>



<script type="text/javascript">

    document.addEventListener('DOMContentLoaded', function() {
    // Find all close buttons
    const closeButtons = document.querySelectorAll('.close-btn');
    
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Find the parent alert div and hide it
            const alert = this.parentElement;
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 300); // Smooth fade out
        });
    });
});


</script>

</body>
</html>