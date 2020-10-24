<?php

$link = mysqli_connect("localhost", "root", "", "restaurante");
 

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
if(isset($_POST['submit'])){
    $idPedido = $_POST['idPedido'];
    $sql = "UPDATE pedidos SET IdEstadoPedido = 4 where IdPedido = $idPedido";
if(mysqli_query($link, $sql)){
    header("location: pedidosPlantilla.php");
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

}

 
mysqli_close($link);
?>