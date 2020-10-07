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
    if(empty(trim($_POST["IdRol"]))){
        $IdRol_err = "Please enter a IdRol.";     
    } else{
        $IdRol = trim($_POST["IdRol"]);
    }
 
    

    // Check input errors before inserting in database
    if(empty($Correo_err) && empty($Contraseña_err) && empty($Nombre_err) && empty($Apellido_err) && empty($IdRol_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO usuarios (Correo, Contraseña, Nombre, Apellido, IdRol) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_Correo, $param_Contraseña, $param_Nombre, $param_Apellido, $param_IdRol);
            
            // Set parameters
            $param_Correo = $Correo;
            $param_Contraseña = password_hash($Contraseña, PASSWORD_DEFAULT); // Creates a Contraseña hash
            $param_Nombre = $Nombre;
            $param_Apellido = $Apellido;
            $param_IdRol = $IdRol;

            
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
            <div class="form-group <?php echo (!empty($IdRol_err)) ? 'has-error' : ''; ?>">
                <input type="hidden" name="IdRol" class="form-control" value="3">
                <span class="help-block"><?php echo $Apellido_err; ?></span>
            </div>


            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>