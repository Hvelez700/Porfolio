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




//get the group id from the url
$group_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($group_id == false) {
    die("Invalid group ID.");
}

$name = "";


$select_query = "SELECT * FROM `_group_` WHERE id = :group_id";
$stmt = $conn->prepare($select_query);
$stmt->bindParam(':group_id', $group_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $name = $result['name'];
} else {
    die("Group not found.");
}


//edit  group
if(isset($_POST['submit'])) {
    $name = $_POST['group_name'];
    
    
    $stmt = $conn->prepare("UPDATE `_group_` SET `name`=:name WHERE `id`=:id");
    //$stmt->bindParam(':name', $name);
    //$stmt->bindParam(':user_id', $user_id);

    try{

        if($stmt->execute(array(':name' => $name, ':id' => $group_id))) {
            $_SESSION['success'] = "Group updated successfully.";
             header("Location: edit-group.php"."?id=".$group_id);
             exit();
        } else {
            $_SESSION['error'] = "Failed to update group.";
             header("Location: edit-group.php".$group_id);
             exit();
        }

    }catch(Exception $ex){
        $_SESSION['error'] = "Failed to update group.".$ex->getMessage();
    }

    

    header("Location: edit-group.php");
    exit();
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Form-style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <title>Edit Groups</title>
</head>
<body>



        
    
    <h1>Edit Group</h1>
    <form action="edit-group.php?id=<?php echo $group_id; ?>" method="post">
        <?php 
               // Display error or success messages
                if(isset($_SESSION['error'])){
                    echo '<div class="alert error"><p>'.$_SESSION['error'].'</p><span class="close">
                    &times;</span></div>'; 
                       unset($_SESSION['error']);             
                }elseif(isset($_SESSION['success'])){
                     echo '<div class="alert success"><p>'.$_SESSION['success'].'</p><span class="close">
                    &times;</span></p></div>'; 
                    unset($_SESSION['success']); 
                }         
        ?> 
        <label for="group_name">Group Name:</label>
        <input type="text" id="group_name" name="group_name"  value="<?php echo $name  ?>" required>
        <button type="submit" name="submit" value="edit Group">edit Group</button>
        <button type="submit" name="submit" value="edit Group"><a href="Group.php" class="back_to_group">Group</a></button>
    </form>



<script>
    // Close alert messages when the close button is clicked
    document.querySelectorAll('.alert .close').forEach(function(closeBtn) {
        closeBtn.addEventListener('click', function() {
            this.parentElement.style.display = 'none';
        });
    });

    </script>





</body>

</html>