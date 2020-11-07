<?php
require_once '../Config/configuracion.php';

?>

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
   <section>
      <div class= "container">  
      <div class="row">
      <?php 
      if(isset($_REQUEST['Descripcion'])){
        $buscar = strtolower($_REQUEST['Descripcion']);
        
      }
      
      ?>
          <div class="col-md-12">
          <div class=" table-responsive-md">
            <table class="table table-bordered">
            <thead>
                <tr>
                  <th>Descricion</th>
                  <th>Precio</th>
                  <th>Habilitado</th>
                </tr>
            </thead>
            <tbody>
              <?php
             $estado='';
             if($buscar == 'habilitado'){
                 $estado= "OR habilitado LIKE '%0%' ";
             }else if($buscar == 'habilitado'){
               $estado= "OR habilitado LIKE '%1%' ";
             }
             
               $result=$mysqli->query("SELECT Ingrediente, Descripcion, precio, habilitado from platillos inner join 
               platillosingredientes on platillos.IdPlatillos = platillosingredientes.IdPlatillo INNER JOIN 
               ingredientes on platillosingredientes.IdIngrediente = ingredientes.IdIngrediente
               WHERE (Ingrediente LIKE '%$buscar%' or precio LIKE '%$buscar%' $estado)");

              $queryEstado = '';
              if(isset($_REQUEST['Habilitado'])){
                $habilitado = $_REQUEST['Habilitado'];
                if ($habilitado == 1) {
                  $queryEstado = 'platillos.habilitado = 1';
                } else {
                  $queryEstado = 'platillos.habilitado = 0';
                }
              } else {
                $queryEstado = 'platillos.habilitado = 0';
              }


               $result2 =$mysqli->query("SELECT Ingrediente, platillos.Descripcion, precio, habilitado from platillos inner join 
           platillosingredientes on platillos.IdPlatillos = platillosingredientes.IdPlatillo INNER JOIN ingredientes 
           on platillosingredientes.IdIngrediente = ingredientes.IdIngrediente WHERE 
           (ingredientes.Ingrediente LIKE '%$buscar%' or platillos.Descripcion LIKE '%$buscar%' or platillos.precio LIKE '%$buscar%') 
           AND $queryEstado group by platillos.Descripcion");


                while ($row = mysqli_fetch_assoc($result2)){
                
              ?>
              <tr>
                <td><?php echo $row['Descripcion']?></td>
                <td><?php echo $row['precio']?></td>
                <td><?php echo $row['habilitado']?></td>
              </tr>
                <?php }
                ?>
            </tbody>
               
            </table>
          </div>
          
         </div>      
        </div>
        <br>
        <br>
        <br><br>
        <br>
    </section>

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