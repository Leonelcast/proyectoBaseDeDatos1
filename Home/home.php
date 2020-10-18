<?php include '../Config/ConfigPdo.php'; ?>
<!doctype html>
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
  <div class="container">
    <div class="row">
      <div class="col-3"></div>
      <div class="col-3">
        <label class="sr-only">Platillos</label>
        <input type="text" name="Platillos" class="form-control" placeholder="Agrega Platillos">
      </div>
      <div class="col-3">


        <label class="sr-only">Ingredientes</label>
        <input type="text" name="Ingredientes" class="form-control" placeholder="Agrega Ingredientes">
      </div>
      <div class="col-3">
      <select class="form-control">
    <option value="0">Disponible</option>
    <option value="0">No Disponible</option>
  </select>
</div>
    </div>
  </div>
 
  
      <br>
      <br>
      <section>
      <div>
          <div class="container">
            <div class="row">
              <div class="col-md-12">
             <center><h3>Almuerzo</h3></center> 
              <hr>
              </div>
              <?php 
                    $result = $mysqli->query("SELECT Descripcion, precio, Fotografia, IdCategoria FROM platillos inner join menus  
                    on platillos.IdMenu= menus.IdMenu where IdCategoria = 2") or die($mysqli->error);
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                    ?>
                  <div class="col-md-3">
                    
                  <img src= "data:image/jpeg;base64,<?php echo base64_encode($row['Fotografia'])?>">
                   <h3 class="menu-item"> <?php echo $row['Descripcion']?></h3> 
                          <b><span class="menu_price">Q <?php echo $row['precio']?></span></b>
                          <br>
                          <a href="order.php" class="btn btn-success pull-right">Order Now</a>
                          <br>
                  </div>
                    <?php }?>
      </section>
      <br>
      <section>
        <div>
            <div class="container">
              <div class="row">
                <div class="col-md-12">
              <center><h3>Cena</h3></center>  
                <hr>
                </div>
                <?php 
                    $result = $mysqli->query("SELECT Descripcion, precio, Fotografia, IdCategoria FROM platillos inner join menus  
                    on platillos.IdMenu= menus.IdMenu where IdCategoria = 3") or die($mysqli->error);
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                    ?>
                  <div class="col-md-3">
                    
                  <img src= "data:image/jpeg;base64,<?php echo base64_encode($row['Fotografia'])?>">
                   <h3 class="menu-item"> <?php echo $row['Descripcion']?></h3> 
                          <b><span class="menu_price">Q <?php echo $row['precio']?></span></b>
                          <br>
                          <a href="order.php" class="btn btn-success pull-right">Order Now</a>
                          <br>
                  </div>
                    <?php }?>
                
        </section>
        <br>
        <section>
          <div>
              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                 <center><h3>Postres</h3></center> 
                  <hr>
                  </div>
                  <?php 
                    $result = $mysqli->query("SELECT Descripcion, precio, Fotografia, IdCategoria FROM platillos inner join menus  
                    on platillos.IdMenu= menus.IdMenu where IdCategoria = 13") or die($mysqli->error);
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                    ?>
                  <div class="col-md-3">
                    
                  <img src= "data:image/jpeg;base64,<?php echo base64_encode($row['Fotografia'])?>">
                   <h3 class="menu-item"> <?php echo $row['Descripcion']?></h3> 
                          <b><span class="menu_price">Q <?php echo $row['precio']?></span></b>
                          <br><a href="order.php" class="btn btn-success pull-right">Order Now</a>
                          <br>
                  </div>
                    <?php }?>
          </section>
          <br>
          <section>
            <div>
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                  <center> <h3>Destacados</h3></center> 
                    <hr>
                    </div>
                    <?php 
                    $result = $mysqli->query("SELECT Descripcion, precio, Fotografia, IdCategoria, destacado FROM platillos inner join menus  
                    on platillos.IdMenu= menus.IdMenu where destacado = true LIMIT 4") or die($mysqli->error);
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                    ?>
                  <div class="col-md-3">
                    
                  <img src= "data:image/jpeg;base64,<?php echo base64_encode($row['Fotografia'])?>">
                   <h3 class="menu-item"> <?php echo $row['Descripcion']?></h3> 
                          <b><span class="menu_price">Q<?php echo $row['precio']?></span></b>
                          <br>
                          <a href="order.php" class="btn btn-success pull-right">Order Now</a>
                          <br>
                  </div>
                    <?php }?>
            </section>
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
  </body>
</html>