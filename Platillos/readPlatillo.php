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
if(isset($_GET["IdPlatillos"]) && !empty(trim($_GET["IdPlatillos"]))){

    require_once "../Config/config.php";

    $sql = "SELECT * FROM platillos WHERE IdPlatillos = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_IdPlatillos); 
        $param_IdPlatillos = trim($_GET["IdPlatillos"]);
        
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $Precio = $row["precio"];
                $IdMenu = $row["IdMenu"];
                $Destacado = $row["destacado"];
                $Habilitado = $row["habilitado"];
                $Descripcion = $row["Descripcion"];
                $Fotografia = $row["Fotografia"];
            } else{
                header("location: errorPlatillo.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    mysqli_stmt_close($stmt);
    
    mysqli_close($link);
} else{
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
  <br>
  <br>
  <br>
  <br>
<div class="row">
                <div class="col-4"></div>
                <div class="col-4">

                <form class="form-signin" id="form">
           <div class="page-header">
           <center> <img src="../img/pizzaLogo.png" alt="Girl in a jacket" id="logoLogin"></center>
                       <center> <h3>Platillos</h3> </center>
                    </div>
                    <div class="form-group">
                        <label>Precio</label>
                        <p class="form-control-static"><?php echo $row["precio"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>IdMenu</label>
                        <p class="form-control-static"><?php echo $row["IdMenu"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Destacado</label>
                        <p class="form-control-static"><?php echo $row["destacado"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Habilitado</label>
                        <p class="form-control-static"><?php echo $row["habilitado"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Descripcion</label>
                        <p class="form-control-static"><?php echo $row["Descripcion"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Fotografia</label>
                        <p class="form-control-static"><?php echo $row["Fotografia"]; ?></p>
                    </div>
                        <p><a href="platillo.php" class="btn btn-primary">Back</a></p>
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


<footer class="page-footer font-small blue" id="Footer">
    <div class="footer-copyright text-center py-3">© 2020 Copyright:
      <a> Pizza Planeta</a>
    </div>
 </footer>


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