<?php
// Include config file
require_once "../Config/config.php";
 
// Define variables and initialize with empty values
$Tipo = "";
$Tipo_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["IdCategoria"]) && !empty($_POST["IdCategoria"])){
    // Get hidden input value
    $IdCategoria = $_POST["IdCategoria"];

    $input_Tipo= trim($_POST["Tipo"]);
    if(empty($input_Tipo)){
        $Tipo_err = "Please enter an destacado.";     
    } else{
        $Tipo = $input_Tipo;
    }
    
    // Check input errors before inserting in database
    if(empty($Tipo_err)){
        // Prepare an update statement
        $sql = "UPDATE categorias SET Tipo=? WHERE IdCategoria=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_Tipo, $param_IdCategoria);
            
            $param_Tipo= $Tipo;
            $param_IdCategoria = $IdCategoria;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: categorias.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["IdCategoria"]) && !empty(trim($_GET["IdCategoria"]))){
        // Get URL parameter
        $IdCategoria =  trim($_GET["IdCategoria"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM categorias WHERE IdCategoria = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_IdCategoria);
            
            // Set parameters
            $param_IdCategoria = $IdCategoria;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $Tipo= $row["Tipo"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    
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
  <div class="row">
                <div class="col-4"></div>
                <div class="col-4">

                <form class="form-signin" id="form" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

           <center> <img src="../img/pizzaLogo.png" alt="Girl in a jacket" id="logoLogin"></center>
           <center><h3 > Actualizar Categoria</h3></center> 
            <hr>

                   <center> <p>Llena los campos para actualizar una nueva categoria</p></center>

                   <div class="form-group <?php echo (!empty($Tipo_err)) ? 'has-error' : ''; ?>">
                            <label>Tipo</label>
                            <input type="text" name="Tipo" class="form-control" value="<?php echo $Tipo; ?>">
                            <span class="help-block"><?php echo $Tipo_err;?></span>
                        </div>
                        <input type="hidden" name="IdCategoria" value="<?php echo $IdCategoria; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="categorias.php" class="btn btn-default">Cancel</a>
          </form>
          <br>

        </div>
                <div class="col-4"></div>



                </div>
            </div>        
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <footer class="page-footer font-small blue" id="Footer">
    <div class="footer-copyright text-center py-3">© 2020 Copyright:
      <a> Pizza Planeta</a>
    </div>
 </footer>
</body>
</html>


 
