<?php 
session_start();
$connect = mysqli_connect("localhost", "root", "", "restaurante");


if(isset($_POST)){
    $n = $_POST['nombre'];
    $d = $_POST['direccion'];
    $t = $_POST['tarjeta'];
    $f = $_POST['fecha_ex'];
    $user=$_SESSION['IdUsuarios'];
    $result2=$connect->query("INSERT INTO `tarjetas` (`IdTarjeta`, `Nombre`, `Direccion`, `NumeroTarjeta`, `FechaExpiracion`, `IdUsuario`) 
    VALUES (NULL, '$n', '$d', '$t', '$f', '$user')");

    $observacion = $_POST['observacion'];
    $user=$_SESSION['IdRol'];

    $result =$connect->query("INSERT INTO `pedidos` (`IdPedido`, `IdEstadoPedido`, `Fecha`, `Confirmado`, `IdUsuarios`, `observacion`)
    VALUES (NULL, '1', NOW(), 1, '$user', '$observacion');");

    $id = $connect->insert_id;

    foreach ($_SESSION["shopping_cart"] as $keys => $value){
        $platillo = $value["item_id"];
        $cantidad = $value["item_quantity"];

        $result3 =$connect->query("INSERT INTO `pedidosplatillos` (`IdPedidoPlatillo`, `IdPedido`, `IdPlatillo`, `cantidad`)
            VALUES (NULL, $id, $platillo, $cantidad);");
    }

    $result4 =$connect->query("SELECT TotalFunc($id) as total;");
    if($row = $result4->fetch_array(MYSQLI_ASSOC)){
        $total = $row['total'];
        $result5 =$connect->query("UPDATE pedidos SET total = $total where IdPedido = $id");
    }
    
    header("Location:home.php");
}
    
?>