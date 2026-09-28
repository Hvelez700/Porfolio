
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

//add a new group
if(isset($_POST['submit'])) {
    $name = $_POST['group_name'];
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("INSERT INTO `_group_`(`name`, `user_id`) VALUES (:name, :user_id)");
    //$stmt->bindParam(':name', $name);
    //$stmt->bindParam(':user_id', $user_id);

    try{

        if($stmt->execute(array(':name' => $name, ':user_id' => $user_id))) {
            $_SESSION['success'] = "Group added successfully.";
             header("Location: add-group.php");
             exit();
        } else {
            $_SESSION['error'] = "Failed to add group.";
             header("Location: add-group.php");
             exit();
        }

    }catch(Exception $ex){
        $_SESSION['error'] = "Failed to add group.".$ex->getMessage();
    }

    

    header("Location: add-group.php");
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
    <title>Add Groups</title>
</head>
<body>



        
    
    <h1>Add Group</h1>
    <form action="add-group.php" method="post">
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
        <input type="text" id="group_name" name="group_name" required>
        <button type="submit" name="submit" value="Add Group">Add Group</button>
        <button type="submit" name="submit" value="edit Group"><a href="contacts.php" class="back_to_group">Cancel</a></button>
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