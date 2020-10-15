<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "../Config/config.php";
 
// Define variables and initialize with empty values
$new_Contraseña = $confirm_Contraseña = "";
$new_Contraseña_err = $confirm_Contraseña_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new Contraseña
    if(empty(trim($_POST["new_Contraseña"]))){
        $new_Contraseña_err = "Please enter the new Contraseña.";     
    } elseif(strlen(trim($_POST["new_Contraseña"])) < 6){
        $new_Contraseña_err = "Contraseña must have atleast 6 characters.";
    } else{
        $new_Contraseña = trim($_POST["new_Contraseña"]);
    }
    
    // Validate confirm Contraseña
    if(empty(trim($_POST["confirm_Contraseña"]))){
        $confirm_Contraseña_err = "Please confirm the Contraseña.";
    } else{
        $confirm_Contraseña = trim($_POST["confirm_Contraseña"]);
        if(empty($new_Contraseña_err) && ($new_Contraseña != $confirm_Contraseña)){
            $confirm_Contraseña_err = "Contraseña did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_Contraseña_err) && empty($confirm_Contraseña_err)){
        // Prepare an update statement
        $sql = "UPDATE usuarios SET Contraseña = ? WHERE IdUsuario = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_Contraseña, $param_IdUsuario);
            
            // Set parameters
            $param_Contraseña = password_hash($new_Contraseña, PASSWORD_DEFAULT);
            $param_IdUsuario = $_SESSION["IdUsuario"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Contraseña updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
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
    <title>Reset Contraseña</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Reset Contraseña</h2>
        <p>Please fill out this form to reset your Contraseña.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_Contraseña_err)) ? 'has-error' : ''; ?>">
                <label>New Contraseña</label>
                <input type="password" name="new_Contraseña" class="form-control" value="<?php echo $new_Contraseña; ?>">
                <span class="help-block"><?php echo $new_Contraseña_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_Contraseña_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Contraseña</label>
                <input type="password" name="confirm_Contraseña" class="form-control">
                <span class="help-block"><?php echo $confirm_Contraseña_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>