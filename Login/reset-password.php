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
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="../Style/index.css" rel="stylesheet">


</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg" id="navbar"> <a class="navbar-brand"  id="TextNavColor" href="./Home.html">Pizza Planeta</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link"  id="TextNavColor" href="./Index.html">Menu</a>
          <a class="nav-item nav-link"  id="TextNavColor" href="./registry.html">Promociones</a>
          <a class="nav-item nav-link"  id="TextNavColor" href="./registry.html">Pedidos</a>
          <a class="nav-item nav-link"  id="TextNavColor" href="./Index.html">Login</a>
          </nav>
  </header>
  <br>
  <br>
  <br>
<section>
<div class="row">
                <div class="col-4"></div>
                <div class="col-4">
                <div class="wrapper">
                <form class="form-signin" id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <center> <img src="../img/pizzaLogo.png" alt="Girl in a jacket" id="logoLogin"></center>
               <center><h2>Cambiar Contraseña</h2></center> 
               <center><p>Ingresa tu nueva contraseña.</p></center>
        
           
          
           <div class="form-group <?php echo (!empty($new_Contraseña_err)) ? 'has-error' : ''; ?>">
                <label>Nueva Contraseña</label>
                <input type="password" name="new_Contraseña" class="form-control" value="<?php echo $new_Contraseña; ?>">
                <span class="help-block"><?php echo $new_Contraseña_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_Contraseña_err)) ? 'has-error' : ''; ?>">
                <label>Confirma tu  Contraseña</label>
                <input type="password" name="confirm_Contraseña" class="form-control">
                <span class="help-block"><?php echo $confirm_Contraseña_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>   
          </form>
          <br>

                </div>
                <div class="col-4"></div>



                </div>
            </div>        
        </div>
    </div>
    </section>
    
<br>
<br>
<br>
<br>


    <footer class="page-footer font-small blue" id="Footer">
    <div class="footer-copyright text-center py-3">© 2020 Copyright:
      <a> Pizza Planeta</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>      
 
</body>
</html>