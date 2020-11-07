<?php
session_start();
if(!isset($_SESSION['IdRol'])){
  header('location: ../Login/login.php');
}else{
  if($_SESSION['IdRol'] !=1){
    header('location: ../Login/login.php');
  }

}

?>
 
 <?php

require_once "../Config/config.php";
 

$IdPlatillos = $precio = $IdMenu = $destacado = $habilitado = $Descripcion = $Fotografia = "";
$IdPlatillos_err = $precio_err =  $IdMenu_err = $destacado_err = $habilitado_err = $Descripcion_err = $Fotografia_err ="";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_precio = trim($_POST["precio"]);
    if(empty($input_precio)){
        $precio_err = "Please enter the precio amount.";     
    } elseif(!ctype_digit($input_precio)){
        $precio_err = "Please enter a positive integer value.";
    } else{
        $precio= $input_precio;
    }


    $input_IdMenu = trim($_POST["IdMenu"]);
    if(empty($input_IdMenu)){
        $IdMenu_err = "Please enter the menuId amount.";     
    } elseif(!ctype_digit($input_IdMenu)){
        $IdMenu_err = "Please enter a positive integer value.";
    } else{
        $IdMenu= $input_IdMenu;
    }
    
    $destacado =$_POST['destacado']; 
    $habilitado =$_POST['habilitado']; 


    $input_Descripcion= trim($_POST["Descripcion"]);
    if(empty($input_Descripcion)){
        $Descripcion_err = "Please enter an destacado.";     
    } else{
        $Descripcion = $input_Descripcion;
    }
    if(isset($_FILES['Fotografia'])){
        $Fotografia = addslashes(file_get_contents($_FILES['Fotografia']['tmp_name']));
        $tipo = $_FILES['Fotografia']['type'];
        $imgContenido = addslashes(file_get_contents($Fotografia));
    }
    
    if(empty($IdPlatillos_err) &&  empty($precio_err)  && empty($IdMenu_err)  && empty($destacado_err)  && empty($habilitado_err) 
     && empty($Descripcion_err) && empty($Fotografia_err)){
      
        $sql = "INSERT INTO platillos(IdPlatillos, precio, IdMenu, destacado, habilitado, Descripcion, Fotografia ) VALUES (0, ?, ?, ?, ?, ?, '{$Fotografia}')";
         
        if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt,"iiiis", $param_precio, $param_IdMenu, $param_destacado, $param_habilitado, $param_Descripcion);
        
            $param_precio = $precio;
            $param_IdMenu   = $IdMenu;
            $param_destacado = $destacado;
            $param_habilitado = $habilitado;
            $param_Descripcion = $Descripcion;
            $param_Fotografia =  $Fotografia ;
            if(mysqli_stmt_execute($stmt)){
                header("location: platillo.php");
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
          </nav>
  </header>
  <br>
  <br>

<section>
<div class="row">
                <div class="col-4"></div>
                <div class="col-4">

                <form class="form-signin" id="form" action="/PROYECTO/Home/Platillos/create.php" enctype="multipart/form-data" method="post">
           <center> <img src="../img/pizzaLogo.png" alt="Girl in a jacket" id="logoLogin"></center>
           <br>
           <center><h2> Agregar Nuevo Platillo</h2></center> 
            <hr>
            <br>

                   <center> <p>Llena los campos para agregar un nuevo platillo</p></center>
                        <div class="form-group <?php echo (!empty($precio_err)) ? 'has-error' : ''; ?>">
                            <label for="precio" class="sr-only">precio</label>
                            <input type="number" name="precio" class="form-control" placeholder="Precio" value="<?php echo $precio; ?>">
                            <span class="help-block"><?php echo $precio_err;?></span>
                        </div>
                        <div class="col-md-12 form-group">
                        <label class="form-label">Tipo de Menu:</label>
                        <select id="IdMenu" name="IdMenu" class="form-control">
                           <option value="0">Seleccione la categoria</option>
                           <?php
                            $query = "SELECT  IdMenu, Tipo FROM menus inner join categorias c on menus.IdCategoria=c.IdCategoria;";
                            $result = mysqli_query($link, $query);

                           ?>
                            <?php
                              while($row = mysqli_fetch_array($result)) { ?>
                                <option value="<?php echo $row['IdMenu'] ?>"><?php echo $row['Tipo'] ?></option>
                              <?php } ?>
                            </select>
                        </div>

                   

         
            <div class="form-group <?php echo (!empty($destacado_err)) ? 'has-error' : ''; ?>">
                            <label class="sr-only">destacado</label>
                            <input type="text" name="destacado" class="form-control"  placeholder="Destacado utilizar 1 y No Destacado utilizar 0" value="<?php echo $destacado; ?>">
                            <span class="help-block"><?php echo $destacado_err;?></span>
                        </div>
                        <div class="form-group">
                            <label for="habilitado" class="sr-only">habilitado</label>
                            <input type="text" name="habilitado" class="form-control" placeholder="Habilitado utilizar 1 y no Habilitado utilizar 0" value="<?php echo $habilitado; ?>">
                        </div>
                        
                        <div class="form-group ">
                            <label class="sr-only">Descripcion</label>
                            <input type="text" name="Descripcion" class="form-control"  placeholder=" Descripcion" value="<?php echo $Descripcion; ?>">
                        </div>

                     
                        
                        <br>
                        <label class="">Fotografia</label>
                    <input type='file' name='Fotografia' class="form-control">
                    <br>
                    <br>
  
                
                    <a href="../PlatilloxIngrediente/PlatilloxIngrediente.php" class="btn btn-success pull-right" style="margin-left: 10px">Editar relacion con Ingredientes</a>
                        <input type="submit" class="btn btn-primary" value="Agregar">
                        <a href="platillo.php" class="btn btn-default">Cancelar</a>
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