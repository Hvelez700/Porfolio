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
$select_query = "SELECT * FROM `_group_` WHERE user_id= :user_id";
$stmt = $conn->prepare($select_query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();



//get the contact id from the url
$contact_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);


if ($contact_id == false) {
    die("Invalid contact ID.");
}



$name = "";
$email = "";
$phone = "";
$address = "";
$group_id = "";

$selected ="";
$group_name ="";

$select_query = "SELECT * FROM `_contact_` WHERE id = :contact_id";
$stmt2 = $conn->prepare($select_query);
$stmt2->bindParam(':contact_id', $contact_id);
$stmt2->execute();
$result = $stmt2->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $name = $result['name'];
    $email = $result['email'];
    $phone = $result['phone'];
    $address = $result['address'];
    $group_id = $result['group_id'];

    //process groups
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
            {
                // Mark the current group as selected
                $selected = $result['group_id'] == $row['id'] ? 'selected="selected"' : '';
                // Assuming your column in the '_group_' table is called 'name'
                $group_name .= '<option value="' . htmlspecialchars($row['id']) . '" ' . $selected . '>' 
                    . htmlspecialchars($row['name']) . '</option>';
                // You can use $group_name as needed
            }


} else {
    die("Contact not found.");
}




//Edit a new contact
if(isset($_POST['submit'])) {
     $name = $_POST['name'];//get form data
     $email = $_POST['email'];
     $phone = $_POST['phone'];
     $address = $_POST['address'];
     $group_id = $_POST['group'];
     

    //prepare sql insert statement
    $stmt = $conn->prepare("DELETE FROM `_contact_` WHERE `id`=:id");
   
    //execute and handle errors
    try{
        //execute the statement
        if($stmt->execute(array(':id' => $contact_id))) {
            $_SESSION['success'] = "Contact deleted successfully.";
           header("Location: contacts.php");
             exit();
        } else {
            $_SESSION['error'] = "Failed to delete contact.";
             header("Location: delete-contact.php?id=$contact_id");
             exit();
        }

    }catch(Exception $ex){
        $_SESSION['error'] = "Failed to delete contact.".$ex->getMessage();
    }

    

   header("Location: delete-contact.php?id=$contact_id");
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
    <title>Delete Contact</title>
</head>
<body>



    <h1>Delete Contact</h1>
    <form action="delete-contact.php?id=<?php echo $contact_id; ?>" method="post">
        
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
        <input type="text" id="name" name="name" value="<?php echo $name ?>" required>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $email ?>" required>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $phone ?>" required>

         <label for="address">Address:</label>
        <textarea rows="4" id="address" name="address" required><?php echo $address ?></textarea>

        <label for="group">Group:</label>


        <!--html elments selected-->
       <select id="group" name="group" required>
        <option value="select-group">----Select Group----</option>
           <?php echo $group_name; ?> 
        </select>
        <button type="submit" name="submit" value="delete Contact">Delete Contact</button>
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