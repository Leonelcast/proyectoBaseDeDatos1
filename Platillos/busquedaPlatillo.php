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
<section >
<div class="col-md-12">
          <div class="container-fluid">
            <table class="table table-bordered">
            <thead>
                <tr>
                  <th>#</th>
                  <th>Precio</th>
                  <th>Tipo</th>
                  <th>Destacado</th>
                  <th>Habilitado</th>
                  <th>Descricion</th>
                  <th>Fotografia</th>
                </tr>
            </thead>
            <tbody>
            <?php


            include '../Config/configuracion.php';
            if(isset($_GET['buscar'])){
              $search = $_GET['buscar'];
              $result=$mysqli->query("SELECT IdPlatillos, precio, Tipo, destacado, habilitado, Descripcion, Fotografia from platillos inner join menus on 
              platillos.IdMenu = menus.IdMenu inner join categorias on menus.IdCategoria = categorias.IdCategoria
                where (IdPlatillos LIKE '%$search%' OR precio LIKE '%$search%' OR Descripcion LIKE '%$search%' OR Tipo LIKE '%$search%')");
              }else {
                $result = $mysqli->query("SELECT IdPlatillos, precio, Tipo, destacado, habilitado, Descripcion, Fotografia from platillos inner join menus on 
                platillos.IdMenu = menus.IdMenu inner join categorias on menus.IdCategoria = categorias.IdCategoria;") or die($mysqli->error);
              }

            while ($row = mysqli_fetch_assoc($result)){
            ?>
            <tr>
            <td><?php echo $row['IdPlatillos']?></td>
            <td><?php echo $row['precio']?></td>
            <td><?php echo $row['Tipo']?></td>
            <td><?php echo $row['destacado']?></td>
            <td><?php echo $row['habilitado']?></td>
            <td><?php echo $row['Descripcion']?></td>
            <td><img src= "data:image/jpeg;base64,<?php echo base64_encode($row['Fotografia'])?>" class="img-responsive"></td>

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