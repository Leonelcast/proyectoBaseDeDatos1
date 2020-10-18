<?php 
include '../Config/ConfigPdo.php';
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'restaurante');
    if(isset($_POST['precio'])){
        $precio =$_POST['precio']; 
        $IdMenu=$_POST['IdMenu']; 
        $destacado = $_POST['destacado'];
        $habilitado =$_POST['habilitado']; 
        $Descripcion =$_POST['Descripcion']; 
        $Fotografia = $_FILES['Fotografia']['tmp_name'];
        $tipo = $_FILES['Fotografia']['type'];
        $imgContenido = addslashes(file_get_contents($Fotografia));
        $mysqli->query("INSERT INTO platillos(IdPlatillos ,precio, IdMenu, destacado, habilitado, Descripcion, Fotografia) 
        VALUES(0,$precio,$IdMenu,$destacado,$habilitado,'$Descripcion','$imgContenido')")
        or die($mysqli->error);

        header("Location: platillo.php");
    
    }
    
    
?>
