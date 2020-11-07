<?php
session_start();
if(!isset($_SESSION['IdRol'])){
  header('location: ../Login/login.php');
}else{
  if($_SESSION['IdRol'] ==1){
    header('location: ../Home/pedidosPlantilla.php');
  }
  if($_SESSION['IdRol'] ==2){
    header('location: ../Home/pedidosPlantilla.php');
  }
  if($_SESSION['IdRol'] ==3){
    header('location: ../Home/UserPedido.php');
  }


}

?>