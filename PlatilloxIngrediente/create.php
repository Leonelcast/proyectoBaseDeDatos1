<?php
/*session_start();
if(!isset($_SESSION['IdRol'])){
  header('location: ../Login/login.php');
}else{
  if($_SESSION['IdRol'] !=1 && $_SESSION['IdRol'] !=2 ){
    header('location: ../Login/login.php');
  }

}
*/
?>
 <?php

require_once "../Config/config.php";
 

$IdPlatillosIngredientes = $IdIngrediente = $IdPlatillo = $Descripcion = $Cantidad =  "";
$IdPlatillosIngredientes_err = $IdIngrediente_err = $IdPlatillo_err = $Descripcion_err = $Cantidad_err = "";
 
 

if($_SERVER["REQUEST_METHOD"] == "POST"){

     $input_IdIngrediente= trim($_POST["IdIngrediente"]);
    if(empty($input_IdIngrediente)){
        $IdIngrediente_err = "Please enter the IdIngrediente amount.";     
    } elseif(!ctype_digit($input_IdIngrediente)){
        $IdIngrediente_err = "Please enter a positive integer value.";
    } else{
        $IdIngrediente= $input_IdIngrediente;
    }


    $input_IdPlatillo= trim($_POST["IdPlatillo"]);
    if(empty($input_IdPlatillo)){
        $IdPlatillo_err = "Please enter the IdPlatillo amount.";     
    } elseif(!ctype_digit($input_IdPlatillo)){
        $IdPlatillo_err = "Please enter a positive integer value.";
    } else{
        $IdPlatillo= $input_IdPlatillo;
    }
    

    $input_Descripcion= trim($_POST["Descripcion"]);
    if(empty($input_Descripcion)){
        $Descripcion_err = "Please enter an Descripcion.";     
    } else{
        $Descripcion = $input_Descripcion;
    }
        
    $input_Cantidad= trim($_POST["Cantidad"]);
    if(empty($input_Cantidad)){
        $Cantidad_err = "Please enter an Cantidad.";     
    } else{
        $Cantidad = $input_Cantidad;
    }
    
    if(empty($IdPlatillosIngredientes_err) && empty($IdIngrediente_err) && empty($IdPlatillo_err) && empty($Descripcion_err) && empty($Cantidad_err)){
      $sql = "INSERT INTO platillosingredientes (IdPlatillosIngredientes, IdIngrediente, IdPlatillo, Descripcion, Cantidad) VALUES (0, ?, ?, ?, ?)";
         
      if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt,"iisi", $param_IdIngrediente, $param_IdPlatillo, $param_Descripcion, $param_Cantidad);
        
            $param_IdIngrediente = $IdIngrediente;
            $param_IdPlatillo   = $IdPlatillo;
            $param_Descripcion = $Descripcion;
            $param_Cantidad = $Cantidad;
            if(mysqli_stmt_execute($stmt)){
                header("location: Platilloxingrediente.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        mysqli_stmt_close($stmt);
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
<nav class="navbar navbar-expand-lg" id="navbar"> <a class="navbar-brand"  id="TextNavColor" href="../Home/home.php">Pizza Planeta</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link"  id="TextNavColor" href="../Home/home.php">Menu</a>
          <a class="nav-item nav-link"  id="TextNavColor" href="../ConexionesUsuario/pedidos.php">Pedidos</a>
          <a class="nav-item nav-link"  id="TextNavColor" href="../ConexionesUsuario/profile.php">Perfil</a>
          <a class="nav-item nav-link"  id="TextNavColor" href="../Login/welcome.php">LogOut</a>
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

                   <div class="col-md-12 form-group">
                        <label class="form-label">Ingrediente</label>
                        <select id="IdIngrediente" name="IdIngrediente" class="form-control">
                           <option value="0">Seleccione el ingrediente</option>
                           <?php
                            $query = "SELECT * FROM ingredientes;";
                            $result = mysqli_query($link, $query);

                           ?>
                            <?php
                              while($row = mysqli_fetch_array($result)) { ?>
                                <option value="<?php echo $row['IdIngrediente'] ?>"><?php echo $row['Ingrediente'] ?></option>
                              <?php } ?>
                            </select>
                        </div>

                   
                        
            <br>
            <div class="col-md-12 form-group">
                        <label class="form-label">Platillos</label>
                        <select id="IdPlatillo" name="IdPlatillo" class="form-control">
                           <option value="0">Seleccione el platillo</option>
                           <?php
                            $query2 = "SELECT * FROM platillos;";
                            $result2 = mysqli_query($link, $query2);

                           ?>
                            <?php
                              while($row2 = mysqli_fetch_array($result2)) { ?>
                                <option value="<?php echo $row2['IdPlatillos'] ?>"><?php echo $row2['Descripcion'] ?></option>
                              <?php } ?>
                            </select>
                        </div>
            <br>
            <div class="form-group <?php echo (!empty($Descripcion_err)) ? 'has-error' : ''; ?>">
                            <label for="Descripcion" class="sr-only">Descripcion</label>
                            <input type="text" name="Descripcion" class="form-control" placeholder="Descripcion" value="<?php echo $Descripcion; ?>">
                            <span class="help-block"><?php echo $Descripcion_err;?></span>
                        </div>
            <br>
            <div class="form-group <?php echo (!empty($Cantidad_err)) ? 'has-error' : ''; ?>">
                            <label class="sr-only">Cantidad</label>
                            <input type="number" name="Cantidad" class="form-control"  placeholder="Agrega el Cantidad" value="<?php echo $Cantidad; ?>">
                            <span class="help-block"><?php echo $Cantidad_err;?></span>
                        </div>
                        <br>
                        <input type="submit" class="btn btn-primary" value="Agregar">
                        <a href="PlatilloxIngrediente.php" class="btn btn-default">Cancelar</a>
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