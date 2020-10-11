<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../Usuarios/UsuarioLog.php");
    exit;
}
 
// Include config file
require_once "../Config/config.php";
 
// Define variables and initialize with empty values
$Correo = $Contraseña =  "";
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
        $sql = "SELECT IdUsuario, Correo, Contraseña, Nombre, Apellido, IdRol FROM usuarios WHERE Correo = ?";
        
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
                    mysqli_stmt_bind_result($stmt, $id, $Correo, $hashed_password,$Nombre,$Apellido,  $IdRol);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($Contraseña, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["IdUsuario"] = $id;
                            $_SESSION["Correo"] = $Correo;
                            $_SESSION["Nombre"] = $Nombre;
                            $_SESSION["Apellido"] = $Apellido;
                            $_SESSION['IdRol']= $IdRol;                            
                            
                            // Redirect user to welcome page
                            header("location: Roles.php");
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
          
        <center><h2>Login</h2></center>
        <p>Please fill in your credentials to login.</p>
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