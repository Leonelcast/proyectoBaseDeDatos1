<?php
session_start();
if(!isset($_SESSION['IdRol'])){
  header('location: ../Login/login.php');
}else{
  if($_SESSION['IdRol'] !=1 && $_SESSION['IdRol'] !=2 ){
    header('location: ../Login/login.php');
  }

}

?>
<?php

require_once "../Config/config.php";
 
$Inventario = $Ingrediente  = "";
$Inventario_err = $Ingrediente_err = "";
 

if(isset($_POST["IdIngrediente"]) && !empty($_POST["IdIngrediente"])){

    $IdIngrediente = $_POST["IdIngrediente"];

    $input_Ingrediente = trim($_POST["Ingrediente"]);
    if(empty($input_Ingrediente)){
        $Ingrediente_err = "Please enter a Ingrediente.";
    } elseif(!filter_var($input_Ingrediente, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Ingrediente_err = "Please enter a valid Ingrediente.";
    } else{
        $Ingrediente = $input_Ingrediente;
    }
    
    $input_Inventario = trim($_POST["Inventario"]);
    if(empty($input_Inventario)){
        $Inventario_err = "Please enter the Inventario amount.";     
    } elseif(!ctype_digit($input_Inventario)){
        $Inventario_err = "Please enter a positive integer value.";
    } else{
        $Inventario = $input_Inventario;
    }
 
    if(empty($Ingrediente_err) && empty($Inventario_err) ){
 
        $sql = "UPDATE ingredientes SET Inventario=?, Ingrediente=? WHERE IdIngrediente=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
        
            mysqli_stmt_bind_param($stmt, "ssi", $param_Inventario, $param_Ingrediente, $param_IdIngrediente);
          
            $param_Inventario = $Inventario;
            $param_Ingrediente = $Ingrediente;
            $param_IdIngrediente = $IdIngrediente;
           
            if(mysqli_stmt_execute($stmt)){
  
                header("location: Ingrediente.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
     
        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
} else{

    if(isset($_GET["IdIngrediente"]) && !empty(trim($_GET["IdIngrediente"]))){
   
        $IdIngrediente =  trim($_GET["IdIngrediente"]);
        
        $sql = "SELECT * FROM ingredientes WHERE IdIngrediente = ?";
        if($stmt = mysqli_prepare($link, $sql)){
           
            mysqli_stmt_bind_param($stmt, "i", $param_IdIngrediente);
  
            $param_IdIngrediente = $IdIngrediente;
            

            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $Inventario = $row["Inventario"];
                    $Ingrediente = $row["Ingrediente"];
                } else{
                    
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
   
        mysqli_stmt_close($stmt);
        
   
        mysqli_close($link);
    }  else{
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
           <center><h3 > Actualizar Ingrediente</h3></center> 
            <hr>

                   <center> <p>Llena los campos para actualizar un nuevo Ingrediente</p></center>

                   <div class="form-group <?php echo (!empty($Inventario_err)) ? 'has-error' : ''; ?>">
                            <label>Inventario</label>
                            <input type="number" name="Inventario" class="form-control" value="<?php echo $Inventario; ?>">
                            <span class="help-block"><?php echo $Inventario_err;?></span>
                        </div>
                   
            <br>
            <div class="form-group <?php echo (!empty($Ingrediente_err)) ? 'has-error' : ''; ?>">
                            <label>Ingrediente</label>
                            <input type="text" name ="Ingrediente" class="form-control" value="<?php echo $Ingrediente; ?>">
                            <span class="help-block"><?php echo $Ingrediente_err;?></span>
                        </div>
            
                        <br>
                        <input type="hidden" name="IdIngrediente" value="<?php echo $IdIngrediente; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Actualizar">
                        <a href="Ingrediente.php" class="btn btn-default">Cancel</a>
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