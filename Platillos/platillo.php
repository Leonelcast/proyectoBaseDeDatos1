<?php
include '../ConexionesUsuario/EmpleadoAdmin.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="../Style/index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    
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
    <section>
      <center>
    <h2>Platillo</h2></center>
    <div class="wrapper" >
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                       
       
                        <a href="createPlatillo.php" class="btn btn-success pull-right">Agregar nuevo Platillo</a>
                        <form class="form-inline my-2 my-lg-0" method="GET" action="busquedaPlatillo.php">
                  <input class="form-control mr-sm-2"  name="buscar" type="search" placeholder="Search" aria-label="Search">
                  <input type="submit" value="Search" class="btn btn-success">
                </form>
                    </div>
                    <?php
                    require_once "../Config/config.php";
                    
                    $sql = "SELECT IdPlatillos, precio, Tipo, destacado, habilitado, Descripcion, Fotografia from platillos inner join menus on 
                    platillos.IdMenu = menus.IdMenu inner join categorias on menus.IdCategoria = categorias.IdCategoria;";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Precio</th>";
                                        echo "<th>Categoria</th>";
                                        echo "<th>Destacado</th>";
                                        echo "<th>Habilitado</th>";
                                        echo "<th>Descripcion</th>";
                                        echo "<th>Fotografia</th>";
                                        echo "<th>Editar/Eliminar</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['IdPlatillos'] . "</td>";
                                        echo "<td>" . $row['precio'] . "</td>";
                                        echo "<td>" . $row['Tipo'] . "</td>";
                                        echo "<td>" . $row['destacado'] . "</td>";
                                        echo "<td>" . $row['habilitado'] . "</td>";
                                        echo "<td>" . $row['Descripcion'] . "</td>";
                                       

                                        echo "<td>". "<img src='data:image/jpeg;base64," .base64_encode($row['Fotografia'])."' />". "</td>";
                                        echo "<td>";
                                        echo "<a href='readPlatillo.php?IdPlatillos=". $row['IdPlatillos'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='updatePlatillo.php?IdPlatillos=". $row['IdPlatillos'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='deletePlatillo.php?IdPlatillos=". $row['IdPlatillos'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
    </section>

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