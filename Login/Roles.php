<?php
session_start();
if(isset($_SESSION['IdRol'])){
    switch($_SESSION['IdRol']){
      case 1:
        header('location: ../Usuarios/Admin.php');
      break;

      case 2:
        header('location: ../Usuarios/Empleado.php');
      break;

      case 3:
        header('location: ../Usuarios/UsuarioLog.php');
      break;

      default:
    }
  }
?>