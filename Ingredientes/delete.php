<?php

if(isset($_POST["IdIngrediente"]) && !empty($_POST["IdIngrediente"])){
    echo '<script>';
    echo 'console.log('. json_encode($IdIngrediente, JSON_HEX_TAG) .')';
    echo '</script>';
   
    require_once "../Config/config.php";
    
    $sql = "DELETE FROM ingredientes WHERE IdIngrediente = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){ 
      
  
        mysqli_stmt_bind_param($stmt, "i", $param_IdIngrediente);
        
 
        $param_IdIngrediente = trim($_POST["IdIngrediente"]);
        

        if(mysqli_stmt_execute($stmt)){
         
            header("location: Ingrediente.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     

    mysqli_stmt_close($stmt);
    
  
    mysqli_close($link);
} else{
   
    if(empty(trim($_GET["IdIngrediente"]))){
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
                            <input type="hidden" name="IdIngrediente" value="<?php echo trim($_GET["IdIngrediente"]); ?>"/>
                            <p>¿Estas seguro de eliminar este dato?</p><br>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="Ingrediente.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>