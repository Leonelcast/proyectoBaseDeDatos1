<?php 
session_start();
$connect = mysqli_connect("localhost", "root", "", "restaurante");


if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		if(!in_array($_GET["id"], $item_array_id))
		{
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'item_id'			=>	$_GET["id"],
				'item_name'			=>	$_POST["hidden_name"],
				'item_price'		=>	$_POST["hidden_price"],
				'item_quantity'		=>	$_POST["quantity"]
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
		}
		else
		{
			echo '<script>alert("Item Already Added")</script>';
		}
	}
	else
	{
		$item_array = array(
			'item_id'			=>	$_GET["id"],
			'item_name'			=>	$_POST["hidden_name"],
			'item_price'		=>	$_POST["hidden_price"],
			'item_quantity'		=>	$_POST["quantity"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}

if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["item_id"] == $_GET["id"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Item Removed")</script>';
				echo '<script>window.location="home.php"</script>';
			}
		}
	}
}

?>
<!DOCTYPE html>
<html>
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
<h3 style ="text-align: center;    ">Busqueda:</h3>
<br>
  <div class="container" >
    <div class="row">
      
      <div class="col-4">
      
       
      </div>
      <div class="col-4">
	  <form action="search.php" method="POST">
	 
	 
		

<label class="sr-only">Platillos</label>
		<input type="text" name="Descripcion" class="form-control" placeholder="Busqueda de Platillos">
		<label>Habilitado: </label>
		<input type="checkbox" name="Habilitado" placeholder="Habilitado" checked value="1	">
		</br>
  <input type="submit" name="buscar" class="btn btn-success" value= "Buscar">
  </form>
      </div>
      <div class="col-4">
   
</div>
    </div>
  </div>

		<br>
    <div class="container">
    <div class="row">
    <div class="col-1"></div>
    <div class="col-10">
    <div style="clear:both"></div>
			<br />
			<h3>Order Details</h3>
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
						<th width="40%">Nombre</th>
						<th width="10%">Cantidad</th>
						<th width="20%">Precio</th>
						<th width="15%">Total</th>
						<th width="5%">Eliminar</th>
					</tr>
					<?php
					if(!empty($_SESSION["shopping_cart"]))
					{
						$total = 0;
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
					?>
					<tr>
						<td><?php echo $values["item_name"]; ?></td>
						<td><?php echo $values["item_quantity"]; ?></td>
						<td>Q <?php echo $values["item_price"]; ?></td>
						<td>Q <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
						<td><a href="home.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
					</tr>
					<?php
							$total = $total + ($values["item_quantity"] * $values["item_price"]);
						}
					?>
					<tr>
						<td colspan="3" align="right">Total</td>
						<td align="right">Q <?php echo number_format($total, 2); ?></td>
						<td></td>
					</tr>
					<?php
					}
					?>
						
				</table>
			</div>
		</div>
   <br>
   <br>
   <div class = "container">
     <div class="row">
       <div class ="col-3"></div>
       <div class ="col-6">
   <form  class="form-signin" id="form" method="POST" action="pedido.php">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Nombre</label>
      <input type="text" class="form-control"  placeholder="Nombre" name="nombre">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Direccion</label>
      <input type="text" class="form-control" id="inputPassword4" placeholder="Direccion" name="direccion">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Numero en la tarjeta</label>
    <input type="text" class="form-control" placeholder="Numero de tarjeta" name="tarjeta">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Fecha de expiracion</label>
      <input type="date" class="form-control" id="inputCity" name="fecha_ex">
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Codigo CV</label>
      <input type="text" class="form-control" id="inputZip">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="observacion">Observacion</label>
      <textarea type="text" class="form-control" name="observacion"></textarea>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Realizar pedido</button>
</form>
</div>
<div class ="col-3"></div>
</div>
</div>

   
    <br>
		<div class="container">
		<center><h3>Menu</h3></center> 
		<hr>
			
			<?php
				$query = "SELECT *
				FROM platillos
				INNER JOIN menus ON platillos.IdMenu = menus.IdMenu
				INNER JOIN categorias ON categorias.IdCategoria = menus.IdCategoria;";
				$result = mysqli_query($connect, $query);
				if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{
				?>
			<div class="col-md-3">
			<center><h4 class="text-info"><?php echo $row["Tipo"]; ?></h4></center>
				<form method="post" action="home.php?action=add&id=<?php echo $row["IdPlatillos"]; ?>">
					<div style="border:3px solid #5cb85c; background-color:whitesmoke; border-radius:5px; padding:16px;" align="center">
					<img src= "data:image/jpeg;base64,<?php echo base64_encode($row['Fotografia'])?>" class="img-responsive">


						<h4 class="text-info"><?php echo $row["Descripcion"]; ?></h4>

						<h4 class="text-danger">Q <?php echo $row["precio"]; ?></h4>

						<input type="text" name="quantity" value="1" class="form-control" />

						<input type="hidden" name="hidden_name" value="<?php echo $row["Descripcion"]; ?>" />

						<input type="hidden" name="hidden_price" value="<?php echo $row["precio"]; ?>" />

						<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />

					</div>
				</form>
			</div>
			
			<?php
					}
				}
			?>
</div>		
		
<div class="container">

<center><h3>Destacados</h3></center> 
<hr>
<?php
	$query = "SELECT * FROM platillos where destacado = true limit 4; ";
	$result = mysqli_query($connect, $query);
	if(mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_array($result))
		{
	?>
<div class="col-md-3">
	<form method="post" action="home.php?action=add&id=<?php echo $row["IdPlatillos"]; ?>">
		<div style="border:3px solid #5cb85c; background-color:whitesmoke; border-radius:5px; padding:16px;" align="center">
		<img src= "data:image/jpeg;base64,<?php echo base64_encode($row['Fotografia'])?>" class="img-responsive">


			<h4 class="text-info"><?php echo $row["Descripcion"]; ?></h4>

			<h4 class="text-danger">Q <?php echo $row["precio"]; ?></h4>

			<input type="text" name="quantity" value="1" class="form-control" />

			<input type="hidden" name="hidden_name" value="<?php echo $row["Descripcion"]; ?>" />

			<input type="hidden" name="hidden_price" value="<?php echo $row["precio"]; ?>" />

			<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />

		</div>
	</form>
</div>
<?php
		}
	}
?>
</div>
</div>
</div>
</div>
<br>
<footer class="page-footer font-small blue" id="Footer">
    <div class="footer-copyright text-center py-3">©️ 2020 Copyright:
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


