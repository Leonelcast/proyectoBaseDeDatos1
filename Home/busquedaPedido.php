<!doctype html>
<html lang="en">
  <head>
    <title>Usuarios</title>
  
    <link href="../Style/index.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
<section >
<div class="col-md-12">
          <div class="container-fluid">
            <table class="table table-bordered">
            <thead>
                <tr>
                  <th>IdPedido</th>
                  <th>NombreEstado</th>
                  <th>Fecha</th>
                  <th>observacion</th>
                  <th>total</th>
                  <th>Correo</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                </tr>
            </thead>
            <tbody>
            <?php


            include '../Config/configuracion.php';
            if(isset($_GET['buscar'])){
              $search = $_GET['buscar'];
              $result=$mysqli->query("SELECT IdPedido, estadopedidos.IdEstadoPedido as IdEstado, estadopedidos.Nombre as NombreEstado, pedidos.Fecha, Confirmado, observacion, total, Correo, usuarios.Nombre as NombreUsuario, Apellido from usuarios INNER JOIN pedidos 
              ON pedidos.IdUsuarios = usuarios.IdUsuario INNER JOIN  estadopedidos on pedidos.IdEstadoPedido = estadopedidos.IdEstadoPedido
                where (IdPedido LIKE '%$search%' OR total LIKE '%$search%' OR Correo LIKE '%$search%')");
              }else {
                $result = $mysqli->query("SELECT IdPedido, estadopedidos.IdEstadoPedido as IdEstado, estadopedidos.Nombre as NombreEstado, pedidos.Fecha, Confirmado, observacion, total, Correo, usuarios.Nombre as NombreUsuario, Apellido from usuarios INNER JOIN pedidos 
                ON pedidos.IdUsuarios = usuarios.IdUsuario INNER JOIN  estadopedidos on pedidos.IdEstadoPedido = estadopedidos.IdEstadoPedido;") or die($mysqli->error);
              }

            while ($row = mysqli_fetch_assoc($result)){
            ?>
            <tr>
            <td><?php echo $row['IdPedido']?></td>
            <td><?php echo $row['NombreEstado']?></td>
            <td><?php echo $row['Fecha']?></td>
            <td><?php echo $row['observacion']?></td>
            <td><?php echo $row['total']?></td>
            <td><?php echo $row['Correo']?></td>
            <td><?php echo $row['NombreUsuario']?></td>
            <td><?php echo $row['Apellido']?></td>
            </tr>
            <?php }?>
            </tbody>
               
            </table>
          </div>
          
         </div>      
        </div>
        <br>
    </section>
    <br>
<br>
<br>
<br>

    <footer class="page-footer font-small blue" id="Footer">
    <div class="footer-copyright text-center py-3">© 2020 Copyright:
      <a> Pizza Planeta</a>
    </div>
 </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>




