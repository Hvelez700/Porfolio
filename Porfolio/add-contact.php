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



//get user groups
//sql query to get groups for the logged-in user
$sql = "SELECT * FROM `_group_` WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);//prepare statement
$stmt->bindParam(':user_id', $_SESSION['user_id']);//bind user id
$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);  //fetch all groups 


//process groups
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Process each group
    $group_name .= '<option value="' . htmlspecialchars($row['id']) . '">' 
                                     . htmlspecialchars($row['name']) . '</option>';
    // You can use $group_name as needed
}


//add a new contact
if(isset($_POST['submit'])) {
     $name = $_POST['name'];//get form data
     $email = $_POST['email'];
     $phone = $_POST['phone'];
     $address = $_POST['address'];
     $group_id = $_POST['group'];
     $user_id = $_SESSION['user_id'];

    // //prepare sql insert statement
     $stmt = $conn->prepare("INSERT INTO `_contact_`(`name`, `email`, `phone`, `address`, `group_id`, `user_id`) VALUES (:name, :email, :phone, :address, :group_id, :user_id)");
    // $stmt->bindParam(':name', $name);
    // $stmt->bindParam(':email', $email);
    // $stmt->bindParam(':phone', $phone);
    // $stmt->bindParam(':address', $address);
    // $stmt->bindParam(':group_id', $group_id);
    // $stmt->bindParam(':user_id', $user_id);



    //execute and handle errors
    try{
        //execute the statement
        if($stmt->execute(array(':name' => $name, ':email' => $email, ':phone' => $phone, ':address' => $address, ':group_id' => $group_id, ':user_id' => $user_id))) {
            $_SESSION['success'] = "Contact added successfully.";
             header("Location: add-contact.php");
             exit();
        } else {
            $_SESSION['error'] = "Failed to add contact.";
             header("Location: add-contact.php");
             exit();
        }

    }catch(Exception $ex){
        $_SESSION['error'] = "Failed to add contact.".$ex->getMessage();
    }

    

    header("Location: add-contact.php");
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
    <title>Add contacts</title>
</head>
<body>



    <h1>Add Contact</h1>
    <form action="add-contact.php" method="post">
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

        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required>

         <label for="address">Address:</label>
        <textarea rows="4" id="address" name="address" required></textarea>

        <label for="group">Group:</label>


        <!--html elments selected-->
       <select id="group" name="group" required>
        <option value="select-group">----Select Group----</option>
            <?php
            //populate groups in dropdown
                foreach ($groups as $group) {
                    echo '<option value="' . htmlspecialchars($group['id']) . '">' 
                         . htmlspecialchars($group['name']) . '</option>';
                }
                ?>
        </select>
        <button type="submit" name="submit" value="Add Contact">Add Contact</button>
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