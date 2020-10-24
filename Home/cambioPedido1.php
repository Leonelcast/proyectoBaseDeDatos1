<?php

$link = mysqli_connect("localhost", "root", "", "restaurante");
 

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
if(isset($_POST['submit'])){
    $idPedido = $_POST['idPedido'];
    $execute = true;

    $result =$link->query("SELECT i.IdIngrediente, Inventario, pir.Cantidad, pp.cantidad FROM ingredientes as i 
    inner join platillosingredientes as pir on pir.IdIngrediente = i.IdIngrediente
      inner join platillos as p on p.IdPlatillos = pir.IdPlatillo 
      inner join pedidosplatillos as pp on pp.IdPlatillo = p.IdPlatillos 
      where IdPedido = $idPedido");

    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        if($row['Inventario'] < ($row['Cantidad'] * $row['cantidad'])) {
            $execute = false;
            break;
        }
    }

    if($execute) {
        $sql = "UPDATE pedidos SET IdEstadoPedido = 2 where IdPedido = $idPedido";
        if(mysqli_query($link, $sql)){
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }

    header("Location:pedidosPlantilla.php");
}

 
mysqli_close($link);
?>