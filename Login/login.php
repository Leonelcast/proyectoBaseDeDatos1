<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "../Config/config.php";
 
// Define variables and initialize with empty values
$Correo = $Contraseña = "";
$Correo_err = $Contraseña_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["Correo"]))){
        $Correo_err = "Please enter Correo.";
    } else{
        $Correo = trim($_POST["Correo"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["Contraseña"]))){
        $Contraseña_err = "Please enter your Contraseña.";
    } else{
        $Contraseña = trim($_POST["Contraseña"]);
    }
    
    // Validate credentials
    if(empty($Correo_err) && empty($Contraseña_err)){
        // Prepare a select statement
        $sql = "SELECT IdUsuario, Correo, Contraseña FROM usuarios WHERE Correo = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_Correo);
            
            // Set parameters
            $param_Correo = $Correo;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $Correo, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($Contraseña, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["IdUsuario"] = $id;
                            $_SESSION["Correo"] = $Correo;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $Contraseña_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $Correo_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($Correo_err)) ? 'has-error' : ''; ?>">
                <label>Correo</label>
                <input type="email" name="Correo" class="form-control" value="<?php echo $Correo; ?>">
                <span class="help-block"><?php echo $Correo_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($Contraseña_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="Contraseña" class="form-control">
                <span class="help-block"><?php echo $Contraseña_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="signUp.php">Sign up now</a>.</p>
        </form>
    </div>    
</body>
</html>