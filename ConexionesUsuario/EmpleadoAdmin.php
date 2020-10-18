<?php
session_start();
if(!isset($_SESSION['IdRol'])){
  header('location: ../Login/login.php');
}else{
  if($_SESSION['IdRol'] !=1 && $_SESSION['IdRol'] !=2 ){
    header('location: ../Login/login.php');
  }

}

?>