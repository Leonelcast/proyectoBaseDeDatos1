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
 
$precio = $IdMenu = $destacado = $habilitado = $Descripcion = /*$Fotografia = */"";
$precio_err =  $IdMenu_err = $destacado_err = $habilitado_err = $Descripcion_err =/* $Fotografia_err =*/ "";
 

if(isset($_POST["IdPlatillos"]) && !empty($_POST["IdPlatillos"])){

    $IdPlatillos = $_POST["IdPlatillos"];

    $precio =$_POST['precio']; 

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
  /*  $input_Fotografia= trim($_POST["Fotografia"]);
    if(empty($input_Fotografia)){
        $Fotografia_err = "Please enter an Fotografia.";     
    } else{
        $Fotografia = $input_Fotografia;
    }*/
    
 
    if(empty($precio_err) && empty($IdMenu_err)  && empty($destacado_err)  && empty($habilitado_err) 
    && empty($Descripcion_err) /* && empty($Fotografia_err)*/ ){
 
        $sql = "UPDATE platillos SET precio=?, IdMenu=?, destacado=?, habilitado=?, Descripcion=? WHERE IdPlatillos=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
        
            mysqli_stmt_bind_param($stmt,"iiiisi", $param_precio, $param_IdMenu, $param_destacado, $param_habilitado, $param_Descripcion, $IdPlatillos);
          
            $param_precio = $precio;
            $param_IdMenu   = $IdMenu;
            $param_destacado = $destacado;
            $param_habilitado = $habilitado;
            $param_Descripcion = $Descripcion;
            $param_IdPlatillos = $IdPlatillos;
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
} else{

    if(isset($_GET["IdPlatillos"]) && !empty(trim($_GET["IdPlatillos"]))){
   
        $IdPlatillos =  trim($_GET["IdPlatillos"]);
        
        $sql = "SELECT * FROM platillos WHERE IdPlatillos = ?";
        if($stmt = mysqli_prepare($link, $sql)){
           
            mysqli_stmt_bind_param($stmt, "i", $param_IdPlatillos);
  
            $param_IdPlatillos = $IdPlatillos;
            

            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $query = "SELECT  IdMenu, Tipo FROM menus inner join 
                    categorias c on menus.IdCategoria=c.IdCategoria;";

                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    
                    $result = mysqli_query($link, $query);
        

                    $precio = $row["precio"];
                    $IdMenu = $row["IdMenu"];
                    $destacado = $row["destacado"];
                    $habilitado = $row["habilitado"];
                    $Descripcion = $row["Descripcion"];
                    $Fotografia = $row["Fotografia"];
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
  <div class="row">
                <div class="col-4"></div>
                <div class="col-4">

                <form class="form-signin" id="form" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

           <center> <img src="../img/pizzaLogo.png" alt="Girl in a jacket" id="logoLogin"></center>
           <center><h3 > Actualizar Ingrediente</h3></center> 
            <hr>

                   <center> <p>Llena los campos para actualizar un nuevo Ingrediente</p></center>
                   
                   <div class="form-group <?php echo (!empty($precio_err)) ? 'has-error' : ''; ?>">
                            <label>Precio</label>
                            <input type="number" name="precio" class="form-control" value="<?php echo $precio; ?>">
                            <span class="help-block"><?php echo $precio_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($IdMenu_err)) ? 'has-error' : ''; ?>">
                   <label class="form-label">Rol</label>
                        <select  name="IdMenu" class="form-control">
                           <?php
                           
                           ?>
                            <?php
                             while($row = mysqli_fetch_array($result)) { ?>
                                <option value="<?php echo $row['IdMenu'] ?>"><?php echo $row['Tipo'] ?></option>
                              <?php }?>
                            </select>
                        </div>
         
            <div class="form-group <?php echo (!empty($destacado_err)) ? 'has-error' : ''; ?>">
                            <label class="sr-only">destacado</label>
                            <input type="text" name="destacado" class="form-control"  placeholder="Destacado utilizar 0 y 1" value="<?php echo $destacado; ?>">
                            <span class="help-block"><?php echo $destacado_err;?></span>
                        </div>
                        <div class="form-group">
                            <label for="habilitado" class="sr-only">habilitado</label>
                            <input type="text" name="habilitado" class="form-control" placeholder="Habilitado Usar 0 y 1" value="<?php echo $habilitado; ?>">
                        </div>
                        
                        <div class="form-group ">
                            <label class="sr-only">Descripcion</label>
                            <input type="text" name="Descripcion" class="form-control"  placeholder=" Descripcion" value="<?php echo $Descripcion; ?>">
                        </div>
                        <br>
                        <input type="hidden" name="IdPlatillos" value="<?php echo $IdPlatillos; ?>"/>
                        <center>
                        <?php
                        echo "<td>". "<img src='data:image/jpeg;base64," .base64_encode($Fotografia)."' />". "</td>"; ?> </center>
                        <br>
                        <input type='file' name='Fotografia' class="form-control">
                        <br>
                        <br>
                        <input type="submit" class="btn btn-primary" value="Actualizar">

                       
                        
                        <a href="platillo.php" class="btn btn-default">Cancel</a>
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