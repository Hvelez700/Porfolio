<?php
// Start the session
session_start();

//check if user is logged in
if (isset($_SESSION['user_id'])) {
    echo $_SESSION['name'];
    
}//if not logged in redirect to login page
else{
    header("Location: Login.php");
}



require_once 'db_connect.php';

$user_id = $_SESSION['user_id'];


//get user connects
//sql query to get connects for the logged-in user
$sql = "SELECT _contact_.id, _contact_.name, _contact_.email, _contact_.phone, 
        _contact_.address, _group_.name AS group_name
        FROM `_contact_` 
        INNER JOIN `_group_` ON _contact_.group_id = _group_.id
        WHERE _contact_.user_id = :user_id";


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
    <title>My Contacts</title>
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
    <h1>My Contacts</h1>
    <div class="search">
        <form action="#" method="post">
            <input type="search" placeholder="search contacts">
            <button type="submit" name="search-submit">Search</button>

        </form>
    </div>

    <table  class="info">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Group</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        // This is the ONLY loop that should exist for this table
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
            echo '<td>' . htmlspecialchars($row['address']) . '</td>';
            echo '<td>' . htmlspecialchars($row['group_name']) . '</td>';
             echo '<td>';
             echo "<a href=edit-contact.php?id=" . htmlspecialchars($row['id']) . "  class='icon icon-edit' title='edit'></a>";
             echo "</td>";
             echo '<td>';
            echo "<a href=delete-contact.php?id=" . htmlspecialchars($row['id']) . "  class='icon icon-delete' title='delete'></a>";
            echo "</td>";
            echo '</tr>';
            
        }
        ?>
    </tbody>
        
    </table>
    <div class="icon-add-container">
        <a href="add-contact.php" class="icon icon-add" title="add contact">
        <i class="fas fa-plus"></i>
    </a>
    </div>

</div>

</body>
</html>