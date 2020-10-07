<?php

session_start();


require_once 'db.php';

function getParameters($post_request = array(), $get_request = array()) {

    $parameters = array();

    //getting the data
    foreach ($post_request as $key => $val) {
        $parameters[$key] = $val;
    }

    foreach ($get_request as $key => $val) {
        $parameters[$key] = $val;
    }
	
    return $parameters;
}


/**
 * getOperation
 **/
function getOperation($parameters=array()) {
  $operation = '';

  $operation = isset($parameters['action']) ? $parameters['action'] : '';

  return $operation;
}

/**
 * getCallback
 **/

function getCallback($parameters=array()) {
  $callback = '';
  
  $callback = isset($parameters['callback']) ? $parameters['callback'] : '';
  
  return $callback;
}

$parameters = array();
$callback = '';
$operation = '';
$result = array();

//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\
// FUNCTIONS
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\

function adminlogin($parameters){
  //Response var
  $data = array();
  /* Get and Validate parameteres*/
  $user = isset($parameters['email']) ? $parameters['email'] : '';
  $pass = isset($parameters['contrasena']) ? $parameters['contrasena'] : '';
  if(strlen(trim($user))<=0 || strlen(trim($user))>30){
    $data['Result'] = "ERROR";
    $data['Message'] = "Debes ingresar tu nombre de usuario.";
    return $data;
  }
  if(strlen(trim($pass))<=0 || strlen(trim($pass))>30){
    $data['Result'] = "ERROR";
    $data['Message'] = "Debes ingresar tu contraseña.";
    return $data;
  }
  /* Get and Validate parameteres*/
  /*Execute function */
  $db = new DB();
  $data = $db->adminlogin($user,$pass);
  
  /*Response */
  return $data;
}



function validateEmail($parameters){
  //Response var
  $data = "";
  /* Get and Validate parameteres*/
  $email = isset($parameters['email']) ? $parameters['email'] : '';
  /* Get and Validate parameteres*/
  if(strlen(trim($email))<=0 || strlen(trim($email))>30){
    $data['Result'] = "ERROR";
    $data['Message'] = "Debes ingresar tu email.";
    return $data;
  }
  /*Execute function */
  $db = new DB();
  $data = $db->validateEmail($email);
  /*Response */
  return $data;
}


function registerUser($parameters){
  //Response var
  $data = array();
  
  $db = new DB();

  if($db->connection_result["Result"] == "OK"){
    $data = $db->registerUser($parameters);
  }else{
    $data = $db->connection_result;
  }
  
  /*Response */
  return $data;
}


function getUser($parameters){
  //Response var
  $data = array();
  
  $db = new DB();

  if($db->connection_result["Result"] == "OK"){
    $data = $db->getUser($parameters['mobile']);
  }else{
    $data = $db->connection_result;
  }
  
  /*Response */
  return $data;
}


//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\
// WORKING WITH PARAMETERS
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\

$parameters = getParameters($_POST, $_GET);
$callback = getCallback($parameters);
$operation = getOperation($parameters);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



switch ($operation) {

  case 'getuser': 
    $result = getuser($parameters);
  break;

  case 'validate-email':
    $result = validateEmail($parameters);
  break;
  case 'login':
    $result = adminlogin($parameters);
  break;
  case 'register':
    $result = registerUser($parameters);
  break;
  default:
    $result['error'] = '1';
    $result['message'] = 'Operación no definida';
}

if (strlen($callback) > 0) {
  echo $callback . '(' . json_encode($result) . ');';
} else {
  echo json_encode($result);
}

?>
