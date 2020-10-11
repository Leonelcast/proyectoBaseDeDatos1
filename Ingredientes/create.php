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
 

$IdIngrediente = $Inventario = $Ingrediente = "";
$IdIngrediente_err = $Inventario_err = $Ingrediente_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_Inventario = trim($_POST["Inventario"]);
    if(empty($input_Inventario)){
        $Inventario_err = "Please enter the Inventario amount.";     
    } elseif(!ctype_digit($input_Inventario)){
        $Inventario_err = "Please enter a positive integer value.";
    } else{
        $Inventario= $input_Inventario;
    }
    

    $input_Ingrediente= trim($_POST["Ingrediente"]);
    if(empty($input_Ingrediente)){
        $Ingrediente_err = "Please enter an Ingrediente.";     
    } else{
        $Ingrediente = $input_Ingrediente;
    }
    
    
    if(empty($IdIngrediente_err) && empty($Inventario_err) && empty($Ingrediente_err)){
      $sql = "INSERT INTO ingredientes (IdIngrediente, Inventario, Ingrediente) VALUES (0, ?, ?)";

        $sqlCheck = "SELECT * from ingredientes WHERE Ingrediente = ?";

        $sqlUpdate = "UPDATE ingredientes set Inventario = ? where Ingrediente = ?";

        if($stmtCheck = mysqli_prepare($link, $sqlCheck)) {
            mysqli_stmt_bind_param($stmtCheck,"s", $param_Ingrediente);
            
            $param_Ingrediente = $Ingrediente;
        
            if(mysqli_stmt_execute($stmtCheck)){
                $result = mysqli_stmt_get_result($stmtCheck);
                if(mysqli_num_rows($result) > 0){
                  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    if($stmtUpdate = mysqli_prepare($link, $sqlUpdate)){
                      
                        mysqli_stmt_bind_param($stmtUpdate,"ss", $param_Inventario, $param_Ingrediente);
                        
                      
                        $param_Inventario = $Inventario + $row["Inventario"];
                        $param_Ingrediente = $Ingrediente;
                        
                        
                        if(mysqli_stmt_execute($stmtUpdate)){
                            header("location: Ingrediente.php");
                            exit();
                        } else{
                            echo "Something went wrong. Please try again later.";
                        }
                    }
                     
                    // Close statement
                    mysqli_stmt_close($stmtUpdate);
                } else {
                    if($stmt = mysqli_prepare($link, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt,"ss", $param_Inventario, $param_Ingrediente);
                        
                        // Set parameters
                        $param_Inventario = $Inventario;
                        $param_Ingrediente = $Ingrediente;
                        
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                            // Records created successfully. Redirect to landing page
                            header("location: Ingrediente.php");
                            exit();
                        } else{
                            echo "Something went wrong. Please try again later.";
                        }
                    }
                     
                    // Close statement
                    mysqli_stmt_close($stmt);
                }

                // Close statement
                mysqli_stmt_close($stmtCheck);
            } else{
                echo "Something went wrong. Please try again later.";
                exit();
            }
        }
    }
    
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link href="../Style/index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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

                <form class="form-signin" id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           <center> <img src="../img/pizzaLogo.png" alt="Girl in a jacket" id="logoLogin"></center>
           <br>
           <center><h2> Agregar Nuevo Ingrediente</h2></center> 
            <hr>
            <br>

                   <center> <p>Llena los campos para agregar un nuevo Ingrediente</p></center>
                        <div class="form-group <?php echo (!empty($Inventario_err)) ? 'has-error' : ''; ?>">
                            <label for="Inventario" class="sr-only">Inventario</label>
                            <input type="number" name="Inventario" class="form-control" placeholder="Agrega el numero de inventario" value="<?php echo $Inventario; ?>">
                            <span class="help-block"><?php echo $Inventario_err;?></span>
                        </div>
            <br>
            <div class="form-group <?php echo (!empty($Ingrediente_err)) ? 'has-error' : ''; ?>">
                            <label class="sr-only">Ingrediente</label>
                            <input type="text" name="Ingrediente" class="form-control"  placeholder="Agrega el Ingrediente" value="<?php echo $Ingrediente; ?>">
                            <span class="help-block"><?php echo $Ingrediente_err;?></span>
                        </div>
                        <br>
                        <input type="submit" class="btn btn-primary" value="Agregar">
                        <a href="Ingrediente.php" class="btn btn-default">Cancelar</a>
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