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
    <div class= "container">
      <div class="row">
        <div class="col-1"></div>
        <div class="col-4">

                <form class="form-inline my-2 my-lg-0" metho="GET" action="busquedaPedido.php">
                  <input class="form-control mr-sm-2"  name="buscar" type="search" placeholder="Search" aria-label="Search">
                  <input type="submit" value="Search" class="btn btn-success">
                </form>
                    
                        <h2 class="pull-left">Pedidos</h2>
        
                  
                    <?php
                    require_once "../Config/config.php";
                    
                    $sql = "SELECT IdPedido, estadopedidos.IdEstadoPedido as IdEstado, estadopedidos.Nombre as NombreEstado, pedidos.Fecha, Confirmado, observacion, Comentario, total, Correo, usuarios.Nombre as NombreUsuario, Apellido from usuarios INNER JOIN pedidos 
                    ON pedidos.IdUsuarios = usuarios.IdUsuario INNER JOIN  estadopedidos on pedidos.IdEstadoPedido = estadopedidos.IdEstadoPedido;";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>IdEstado</th>";
                                        echo "<th>Estado</th>";
                                        echo "<th>Fecha</th>";
                                        echo "<th>Observacion</th>";
                                        echo "<th>total</th>";
                                        echo "<th>Correo</th>";
                                        echo "<th>Nombre</th>";
                                        echo "<th>Apellido</th>";
                                        echo "<th>Comentario</th>";
                                        echo "<th>Estado</th>";
                                        
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['IdPedido'] . "</td>";
                                        echo "<td>" . $row['IdEstado'] . "</td>";
                                        echo "<td>" . $row['NombreEstado'] . "</td>";
                                        echo "<td>" . $row['Fecha'] . "</td>";
                                        echo "<td>" . $row['observacion'] . "</td>";
                                        echo "<td>" . $row['total'] . "</td>";
                                        echo "<td>" . $row['Correo'] . "</td>";
                                        echo "<td>" . $row['NombreUsuario'] . "</td>";
                                        echo "<td>" . $row['Apellido'] . "</td>";
                                        echo "<td>" . $row['Comentario'] . "</td>";
                                        echo "<td>";  "</td>";
                                        echo "<a href='UEmpleadoC.php?IdPedido=". $row['IdPedido'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                        $idPedido = $row['IdPedido'];
                                        if($row['IdEstado'] ==1){
                                            echo "<form action='cambioPedido1.php' method='post'>";
                                            echo "<input type='submit' name='submit' value='Preparar' class='btn btn-success'>"; 
                                            echo "<input type='hidden' name='idPedido' value='$idPedido'>"; 
                                            echo "</form>";
                                                                                    
                                            
                                        }
                                        else if($row['IdEstado'] == 2){
                                            echo "<form action='cambioPedido2.php' method='post'>";
                                            echo "<input type='submit' name='submit' value='Enviar' class='btn btn-success'>"; 
                                            echo "<input type='hidden' name='idPedido' value='$idPedido'>"; 
                                            echo "</form>";
                                        }
                                        else if($row['IdEstado'] == 3){
                                            echo "<form action='cambioPedido3.php' method='post'>";
                                            echo "<input type='submit' name='submit' value='Entregar' class='btn btn-success'>"; 
                                            echo "<input type='hidden' name='idPedido' value='$idPedido'>"; 
                                            echo "</form>";
                                        }
                                        
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
        <div class="col-1"></div>
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