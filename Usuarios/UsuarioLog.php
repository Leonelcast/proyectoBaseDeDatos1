<?php
// Initialize the session
include '../ConexionesUsuario/UsuarioLog.php';

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
                       <center> <h3>Usuario</h3> </center>
                    </div>
                    <div class="form-group">
                    
                <center><strong>Correo</strong></center>        
                    <center> <p class="form-control-static"><?php echo htmlspecialchars($_SESSION["Correo"]); ?></p></center>    
                    </div>
                   
               <center>    <div class="form-group">
                        <strong>Nombre</strong>
                        <p class="form-control-static" name="Nombre"><?php echo htmlspecialchars($_SESSION["Nombre"]); ?></p>
                    </div></center> 
                    <center>
                    <div class="form-group">
                    <strong>Apellido</strong>
                        <p class="form-control-static" name="Apellido"><?php echo htmlspecialchars($_SESSION["Apellido"]); ?></p></center> 
                    
                        <center> <p>
     <a href="#" title="Placeholder link title" class="text-decoration-none">
          Agrega tu tarjeta de Credito
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-credit-card-2-back" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M14 3H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z"></path>
  <path d="M11 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1zM1 9h14v2H1V9z"></path>
</svg>
        </a>
      </p></center>   
      <br>
                        <p><a href="../Login/welcome.php" class="btn btn-primary">Back</a></p>
                        
      
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