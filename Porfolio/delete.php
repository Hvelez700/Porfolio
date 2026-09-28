 <?php


session_start();

// 1. Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

require_once 'db_connect.php';

// 2. Get the group ID from the URL
$group_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$group_id) {
    die("Invalid group ID.");
}

// 3. Handle the Deletion after Form Submission
if (isset($_POST['submit'])) {
    try {
    // Check both ID and User_ID for security
    $stmt = $conn->prepare("DELETE FROM `_group_` WHERE id = :id AND user_id = :user_id");
    $stmt->bindParam(':id', $group_id);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);

    if ($stmt->execute()) {
        // If rowCount is 0, it means the ID didn't exist or didn't belong to the user
        if ($stmt->rowCount() > 0) {
            $_SESSION['success'] = "Group deleted successfully.";
        } else {
            $_SESSION['error'] = "Group not found or unauthorized.";
        }
        
        header("Location: Group.php"); 
        exit();
    }
} catch (Exception $ex) {
    $_SESSION['error'] = "Error: " . $ex->getMessage();
}
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Form-style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <title>Remove Group</title>


    <style>

        p{
            font-size: 18px;
            margin-bottom: 30px;
            text-align: center;
            color:#555;
        }

        .cancel-button {
            display: inline-block;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            background-color:#2ecc71;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width:45%;
            margin-left:20px;
            box-sizing: border-box;
            text-align: center;
            transition: background-color 0.3s ease-in-out;
        }

        .cancel-button:hover {
            background-color: #3a8258;
        }

        button[type="submit"]{
            background-color: #f44336;
            box-sizing: border-box;
            text-align: center;
            width:40%;
        }

        button[type="submit"]:hover {
            background-color: #d32f2f;
        }   

        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        



    </style>


</head>
<body>



        
    
    <h1>Remove Group</h1>
    <form action="delete.php?id=<?php echo $group_id; ?>" method="post">
        <p>Are you sure you want to remove this group?</p>
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
        <div class="button-container">
            <button type="submit" name="submit" value="Delete Group">Delete</button>
            <a href="Group.php"  class="cancel-button "title="back to group" >Cancel</a>
         </div>
    </form>



<script type='text/javascript'>
    // Close alert messages when the close button is clicked
    document.querySelectorAll('.alert .close').forEach(function(closeBtn) {
        closeBtn.addEventListener('click', function() {
            this.parentElement.style.display = 'none';
        });
    });


    //delete Group 
   

</script>





</body>

</html>