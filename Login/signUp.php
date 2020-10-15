


<?php
// Include config file
require_once "../Config/config.php";
 
// Define variables and initialize with empty values
$Correo = $Contraseña = $Nombre = $Apellido = $IdRol = "";
$Correo_err = $Contraseña_err = $Nombre_err = $Apellido_err = $IdRol_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate Correo
    if(empty(trim($_POST["Correo"]))){
        $Correo_err = "Please enter a Correo.";
    } else{
        // Prepare a select statement
        $sql = "SELECT IdUsuario FROM usuarios WHERE Correo = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_Correo);
            
            // Set parameters
            $param_Correo = trim($_POST["Correo"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $Correo_err = "This Correo is already taken.";
                } else{
                    $Correo = trim($_POST["Correo"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate Contraseña
    if(empty(trim($_POST["Contraseña"]))){
        $Contraseña_err = "Please enter a Contraseña.";     
    } elseif(strlen(trim($_POST["Contraseña"])) < 6){
        $Contraseña_err = "Contraseña must have atleast 6 characters.";
    } else{
        $Contraseña = trim($_POST["Contraseña"]);
    }

    if(empty(trim($_POST["Nombre"]))){
        $Nombre_err = "Please enter a Nombre.";     
    } else{
        $Nombre = trim($_POST["Nombre"]);
    }

    if(empty(trim($_POST["Apellido"]))){
        $Apellido_err = "Please enter a Apellido.";     
    } else{
        $Apellido = trim($_POST["Apellido"]);
    }

 
    

    // Check input errors before inserting in database
    if(empty($Correo_err) && empty($Contraseña_err) && empty($Nombre_err) && empty($Apellido_err) && empty($IdRol_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO usuarios (Correo, Contraseña, Nombre, Apellido, IdRol) VALUES (?, ?, ?, ?, 3)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_Correo, $param_Contraseña, $param_Nombre, $param_Apellido);
            
            // Set parameters
            $param_Correo = $Correo;
            $param_Contraseña = password_hash($Contraseña, PASSWORD_DEFAULT); // Creates a Contraseña hash
            $param_Nombre = $Nombre;
            $param_Apellido = $Apellido;

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
    <title>Sign Up</title>
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

<section>
<div class="row">
                <div class="col-4"></div>
                <div class="col-4">
                <div class="wrapper">
                <form class="form-signin" id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           <center> <img src="../img/pizzaLogo.png" alt="Girl in a jacket" id="logoLogin"></center>
          
        <center><h2>Sign Up</h2></center>
        <center><p>Llena este formulario para crear una cuenta.</p></center>
        
        
            <div class="form-group <?php echo (!empty($Correo_err)) ? 'has-error' : ''; ?>">
                <label>Correo</label>
                <input type="text" name="Correo" class="form-control" value="<?php echo $Correo; ?>">
                <span class="help-block"><?php echo $Correo_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($Contraseña_err)) ? 'has-error' : ''; ?>">
                <label>Contraseña</label>
                <input type="password" name="Contraseña" class="form-control" value="<?php echo $Contraseña; ?>">
                <span class="help-block"><?php echo $Contraseña_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($Nombre_err)) ? 'has-error' : ''; ?>">
                <label>Nombre</label>
                <input type="Nombre" name="Nombre" class="form-control" value="<?php echo $Nombre; ?>">
                <span class="help-block"><?php echo $Nombre_err; ?></span>
            </div>
           
            <div class="form-group <?php echo (!empty($Apellido_err)) ? 'has-error' : ''; ?>">
                <label>Apellido</label>
                <input type="Nombre" name="Apellido" class="form-control" value="<?php echo $Apellido; ?>">
                <span class="help-block"><?php echo $Apellido_err; ?></span>
            </div>


            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
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