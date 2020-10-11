<?php
/*session_start();
if(!isset($_SESSION['IdRol'])){
  header('location: ../Login/login.php');
}else{
  if($_SESSION['IdPlatillosIngredientes'] !=1 && $_SESSION['IdPlatillosIngredientes'] !=2 ){
    header('location: ../Login/login.php');
  }

}
*/
?>

<?php

if(isset($_POST["IdPlatillosIngredientes"]) && !empty($_POST["IdPlatillosIngredientes"])){
   
   
    require_once "../Config/config.php";
    
    $sql = "DELETE FROM platillosingredientes WHERE IdPlatillosIngredientes = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){ 
      
  
        mysqli_stmt_bind_param($stmt, "i", $param_IdPlatillosIngredientes);
        
 
        $param_IdPlatillosIngredientes = trim($_POST["IdPlatillosIngredientes"]);
        

        if(mysqli_stmt_execute($stmt)){
         
            header("location: PlatilloxIngrediente.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     

    mysqli_stmt_close($stmt);
    
  
    mysqli_close($link);
} else{
   
    if(empty(trim($_GET["IdPlatillosIngredientes"]))){
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link href="../Style/index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Delete Record</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="IdPlatillosIngredientes" value="<?php echo trim($_GET["IdPlatillosIngredientes"]); ?>"/>
                            <p>¿Estas seguro de eliminar este dato?</p><br>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="Platilloxingrediente.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>