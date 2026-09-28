<?php 
// Include database connection file
require_once 'db_connect.php';

session_start();


$error_msg = "";

/*
if(isset($_SESSION['user_id'])){
    header('Location:contacts.php');
    exit();
} */



// Check if the form is submitted
if(isset($_POST['submit'])){
    // Retrieve and sanitize form inputs
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Sanitize where it makes sense
    $email    = filter_var($email, FILTER_SANITIZE_EMAIL); // remove illegal chars

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // handle invalid email 
        die("Invalid email format");

    }


    
    // Prepare and execute the insert statement
    $stmt = $conn -> prepare("SELECT * FROM `user` WHERE email = :email");
     $stmt -> bindParam(':email', $email);
    $stmt -> execute();
    
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);

    // If user found and password matches
    if($result && password_verify($password, $result['password'])){
        // Set session variables
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['name'] = $result['fullname'];
        // Redirect to contacts page
        header('Location: contacts.php');
        exit();
    } else {
        // Invalid credentials
        $error_msg = "Invalid email or password";
    }
    
     $conn = null;
     }
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register-style.css" type="text/css">
    <link rel="stylesheet" href="Login-style.css" type="text/css">
    <title>Login Form</title>
</head>
<body>

<div class="signup-wrapper">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="sign-up-form">
        
        <?php 
            if (isset($_SESSION['success'])) {
                 echo '<div class="alert success"><p>'.$_SESSION['success'].'<span class="close">
                    &times;</span></p></div>'; 
            }
        ?>
    <h1>Login</h1>

        <div class="form-group">
            <label for="email">email</label> 
            <input type="email" id="email" name="email" required> 
        </div>
        <div class="form-group">
            <label for="name">Password</label> 
            <input type="password" id="password" name="password" required> 
        </div>
        <?php echo "<p style='color:red; margin-top:10px; margin-bottom:10px;'>".$error_msg."</p>"?>
        <div class="form-group">
            <button type="submit" name="submit">Login</button>
        </div>
        <p>I don not have an account <a href="register.php">Register</a></p>
    </form>

</div>
    
</body>
</html>