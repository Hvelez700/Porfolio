
<?php 
// Include database connection file
require_once 'db_connect.php';



session_start();

// Check if the form is submitted
if(isset($_POST['submit'])){
  
    
    // Retrieve and sanitize form inputs
    $fullname = trim($_POST['fullname'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Sanitize where it makes sense
    $fullname = filter_var($fullname, FILTER_SANITIZE_SPECIAL_CHARS);
    $email    = filter_var($email, FILTER_SANITIZE_EMAIL); // remove illegal chars

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // handle invalid email 
        die("Invalid email format");

    }


    //Check if email already exists
    $stmt = $conn -> prepare("SELECT * FROM `user` WHERE email = :email");
     $stmt -> bindParam(':email', $email);
     $stmt -> execute();
     
     if($stmt->rowCount() > 0){
        header("Location: Register.php");
        $_SESSION['error'] = "Email already exists";
        exit();
     }


     //error if the password is less than 8 characters
     if(strlen($password) < 8){
        header("Location: Register.php");
        $_SESSION['error'] = "Password must be at least 8 characters long";
        exit();
     }

     


    // Then hash the password before storing
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    // Prepare and execute the insert statement
    $stmt = $conn -> prepare("INSERT INTO `user`(`fullname`, `email`, `password`) VALUES (:fullname, :email, :password)");
   
    // Bind parameters and execute
     $stmt -> bindParam(':fullname', $fullname);
     $stmt -> bindParam(':email', $email);
     $stmt -> bindParam(':password', $passwordHash);
     

    try{
       // Execute the statement
    if($stmt -> execute()){
        // Redirect to login page after successful registration
        $_SESSION['success'] = "Registration successful! You can now log in.";
        header('Location: Login.php');
         exit();
    }else{
        $_SESSION['error'] = "Registration failed. Please try again.";
        header('Location: Register.php');
        exit();
    }
        
    }catch (PDOException $e){
        die("Error occurred: " . $e->getMessage()); 
    }

  
     //unset($_SESSION['success']);
     ///unset($_SESSION['error']);
     $conn = null;
}
     
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register-style.css" type="text/css">
    <title>Sign up Form</title>
</head>
<body>

<div class="signup-wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="sign-up-form">
       <?php 

           
               // Display error or success messages
                if(isset($_SESSION['error'])){
                    echo '<div class="alert error"><p>'.$_SESSION['error'].'</p><span class="close">
                    &times;</span></div>';                
                }elseif(isset($_SESSION['success'])){
                     echo '<div class="alert success"><p>'.$_SESSION['success'].'</p><span class="close">
                    &times;</span></p></div>'; 
                }
                
                // Clear messages after displaying
                unset($_SESSION['error']);
                unset($_SESSION['success']);  
        ?> 
    
    <h1>Sign Up</h1>
        <div class="form-group">
            <label for="name">FullName</label> 
            <input type="text" id="name" name="fullname" required> 
        </div>
        <div class="form-group">
            <label for="email">email</label> 
            <input type="email" id="email" name="email" required> 
        </div>
        <div class="form-group">
            <label for="name">Password</label> 
            <input type="password" id="password" name="password" required> 
        </div>
         
        <div class="form-group">
            <button type="submit" name="submit" >Register</button>
        </div>
        <p>Already have an account? <a href="Login.php">Login here</a></p>
    </form>


</div>
    
</body>





<script>
    // Close alert messages when the close button is clicked
    document.querySelectorAll('.alert .close').forEach(function(closeBtn) {
        closeBtn.addEventListener('click', function() {
            this.parentElement.style.display = 'none';
        });
    });

    </script>



















</html>