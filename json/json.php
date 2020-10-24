<?php


if(isset($_GET["IdMenu"]) && !empty(trim($_GET["IdMenu"]))){
 
    require_once "../Config/config.php";
    $response = new stdClass();
    
        $id = $_GET["IdMenu"];
        $sql = "SELECT * from platillos where IdMenu = $id";
        $final = array();
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                $jsonData = array();
                while($row = mysqli_fetch_assoc($result)) {

                    $idPlatillo = $row['IdPlatillos'];
                    $precio = $row['precio'];
                    $destacado = $row['destacado'];
                    $habilitado = $row['habilitado'];
                    $descripcion = $row['Descripcion'];

                    $jsonData = array('IdPlatillos' => "".$idPlatillo."",'precio' => "".$precio.""
                    ,'destacado' => "".$destacado."", 'habilitado' => "".$habilitado."", 'Descripcion' => "".$descripcion."");
                    
                    array_push($final, $jsonData);
                } 
                header('Content-Type: application/json');
                echo json_encode($final);
            }
        }
    
  
    mysqli_close($link);
} else{
   
    header("location: error.php");
    exit();
}
?>