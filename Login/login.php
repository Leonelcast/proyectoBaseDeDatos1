<?php
$Correo_err="debes ingresar tu correo";
$Contraseña_err="debes de ingresar tu contraseña";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($Correo_err)) ? 'has-error' : ''; ?>">
                <label>Correo</label>
                <input type="text" name="Correo" id="email" class="form-control" value="">
                <span class="help-block"><?php echo $Correo_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($Contraseña_err)) ? 'has-error' : ''; ?>">
                <label>Contraseña</label>
                <input type="Contraseña" id ="contrasena" name="Contraseña" class="form-control" value="">
                <span class="help-block"><?php echo $Contraseña_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>   
    <script type="text/javascript">
$( document ).ready(function() {
	$(".btn-primary").click(login);
});
function login(event){
    event.preventDefault();
	var form_data = {};
	form_data.email = $("#email").val();
	form_data.contrasena = $("#contrasena").val();
    form_data.action = "login";
    var service = $.post('/PROYECTO/Home/Servicios/service.php',form_data,function(){},'json');
    service.done(function(data){
        localStorage.setItem('api_token',data.token);
        localStorage.setItem('name',data.name);
        alert(data.Message);
       // window.location.replace(site_vars['host_url']+'/dashboard');
    });
    service.fail(function(data){
        console.log(data);
    });
}
    </script>
</body>
</html>