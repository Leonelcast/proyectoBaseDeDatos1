<?php
/**
* @Filename: DB.php
* Location: include/include.php
* Function: Create and execute statements in the database
* @Creator: David Xocoy (DX)
* Changes: 
* 
*/

//require __DIR__ . '/../vendor/autoload.php';

class DB {
	/**
	* class DB
	*
	*	Function: Contain the conection of data base and function to consult and save data.
	*/

	
	function __construct(){
		// Database configuration
		$dbHost 	= 'localhost';
		$dbUsername = 'root';
		$dbPassword = "";
		$dbName 	= 'restaurante';
		$this->connection_result = array();
		//error_log("CONFIGURACION");
		try {
		// Connect database
			$conn = new PDO('mysql:host='.$dbHost.';dbname='.$dbName, $dbUsername, $dbPassword);
			$this->db = $conn;
		    $this->connection_result["Result"] = "OK";
		    $this->connection_result["Message"] = "";
		} catch (PDOException $e) {
		    error_log("¡Error!: " . $e->getMessage() . "<br/>");
		    $this->connection_result["Result"] = "ERROR";
		    $this->connection_result["Message"] = $e->getMessage();
		    die();
		}
	}


	function registerUser($params){
		
		$ad = $this->db->prepare("INSERT INTO  user(`name`,`location`,`birth_date`,`identification`,`gender`,`email`,`mobile`,`code`,`virified`,`address`, `department`) 
								  VALUES(:name,:location,:birth_date,:identification,:gender,:email,:mobile,:code,:virified, :address, :department)");


		$params['location'] = isset($_SESSION['location']) ? $_SESSION['location'] : '';
		$params['code'] = isset($_SESSION['code']) ? $_SESSION['code'] : '';
		$params['mobile'] = isset($_SESSION['mobile']) ? $_SESSION['mobile'] : '';
		$params["virified"] = "1";
		//$params['ad_name'] = mb_convert_encoding($params['ad_name'], "ISO-8859-1", mb_detect_encoding($params['ad_name'], "UTF-8, ISO-8859-1, ISO-8859-15", true));

		$ad->bindParam(':name',$params['name']);
		$ad->bindParam(':location',$params['location']);
		$ad->bindParam(':birth_date',$params['birth_date']);
		$ad->bindParam(':identification',$params['identification']);
		$ad->bindParam(':gender',$params['gender']);
		$ad->bindParam(':email',$params['email']);
		$ad->bindParam(':mobile',$params['mobile']);
		$ad->bindParam(':code',$params['code']);
		$ad->bindParam(':virified',$params["virified"]);
		$ad->bindParam(':address',$params['address']);
		$ad->bindParam(':department',$params['department']);
		$data = array();

		$qsent = $ad->execute();

		$data['Result'] = "OK";
		if(!$qsent){
			$qerror = $ad->errorInfo();
			$data['Result'] = "ERROR";
			$data['Message'] = $qerror;
			error_log(json_encode($data));
		}
		return $data;
	}



	function saveEvaluation($params){
		$data = array();
		
		$ad = $this->db->prepare("INSERT INTO  evaluation(`user_id`,`symptom_id`) 
								  VALUES(:user_id,:symptom_id)");

		$ad->bindParam(':user_id',$params['user_id']);
		$ad->bindParam(':symptom_id',$params['symptom_id']);
		$data = array();

		$qsent = $ad->execute();
		$data['Result'] = "OK";

		if(!$qsent){
			$qerror = $ad->errorInfo();
			$data['Result'] = "ERROR";
			$data['Message'] = $qerror;
			error_log(json_encode($data));
		}

		return $data;
	}



	function registerAd($params){


		$verify = $this->verifyAdExistence($params);

		
		if($verify['Result']=="OK"){
			$ad = $this->db->prepare("UPDATE  adreport 
								  SET  name=:name, clicks=:clicks, reach=:reach, frequency=:frequency, impressions=:impressions,
									  account_currency=:account_currency, likes=:likes, spend=:spend, date_start=:date_start, date_stop=:date_stop,
									  preview=:preview
								  WHERE ad_id = :ad_id ");


			$params['ad_name'] = mb_convert_encoding($params['ad_name'], "ISO-8859-1", mb_detect_encoding($params['ad_name'], "UTF-8, ISO-8859-1, ISO-8859-15", true));
			$params['preview'] = mb_convert_encoding($params['preview'], "ISO-8859-1", mb_detect_encoding($params['preview'], "UTF-8, ISO-8859-1, ISO-8859-15", true));


			$params['likes'] = array_search("like", array_column($params['actions'], 'action_type'));

			if($params['actions'][$params['likes']]==FALSE){
				$params['likes'] = "";
			}else{
				$params['likes'] = $params['actions'][$params['likes']];
			}

			if($params['likes']['action_type']=="like"){
				$params['likes'] = $params['likes']['value'];
			}else{
				$params['likes'] = "-1";
			}


			$ad->bindParam(':ad_id',$params['ad_id']);
			$ad->bindParam(':name',$params['ad_name']);
			$ad->bindParam(':clicks',$params['clicks']);
			$ad->bindParam(':reach',$params['reach']);
			$ad->bindParam(':frequency',$params['frequency']);
			$ad->bindParam(':impressions',$params['impressions']);
			$ad->bindParam(':account_currency',$params['account_currency']);
			$ad->bindParam(':likes',$params['likes']);
			$ad->bindParam(':spend',$params['spend']);
			$ad->bindParam(':date_start',$params['date_start']);
			$ad->bindParam(':date_stop',$params['date_stop']);
			$ad->bindParam(':preview',$params['preview']);

			$qsent = $ad->execute();
			$qerror = $ad->errorInfo();

			//echo "UPDATE\n";
			//print_r($qerror);
		}else{
			$ad = $this->db->prepare("INSERT INTO adreport(`ad_id`,`name`,`clicks`,`reach`,`frequency`,`impressions`,`account_currency`,`likes`,`spend`,`date_start`,`date_stop`,`preview`) 
								  VALUES(:ad_id,:name,:clicks,:reach,:frequency,:impressions,:account_currency,:likes,:spend,:date_start,:date_stop,:preview)");

			$params['ad_name'] = mb_convert_encoding($params['ad_name'], "ISO-8859-1", mb_detect_encoding($params['ad_name'], "UTF-8, ISO-8859-1, ISO-8859-15", true));
			$params['preview'] = mb_convert_encoding($params['preview'], "ISO-8859-1", mb_detect_encoding($params['preview'], "UTF-8, ISO-8859-1, ISO-8859-15", true));



			$params['likes'] = array_search("like", array_column($params['actions'], 'action_type'));

			if($params['actions'][$params['likes']]==FALSE){
				$params['likes'] = "";
			}else{
				$params['likes'] = $params['actions'][$params['likes']];
			}

			if($params['likes']['action_type']=="like"){
				$params['likes'] = $params['likes']['value'];
			}else{
				$params['likes'] = "-1";
			}

			$ad->bindParam(':ad_id',$params['ad_id']);
			$ad->bindParam(':name',$params['ad_name']);
			$ad->bindParam(':clicks',$params['clicks']);
			$ad->bindParam(':reach',$params['reach']);
			$ad->bindParam(':frequency',$params['frequency']);
			$ad->bindParam(':impressions',$params['impressions']);
			$ad->bindParam(':account_currency',$params['account_currency']);
			$ad->bindParam(':likes',$params['likes']);
			$ad->bindParam(':spend',$params['spend']);
			$ad->bindParam(':date_start',$params['date_start']);
			$ad->bindParam(':date_stop',$params['date_stop']);
			$ad->bindParam(':preview',$params['preview']);

			$qsent = $ad->execute();
			//echo "INSERT\n";
			//print_r($qsent);
		}
	}


	function verifyAdExistence($params){
		/**
		* Log a report User or solve error if have incorrect credentials.
		*
		* @param string $username is username
		* @param string $pass is the user password
		*/
		//Response var
		$data = array();
		//Prepare SQL
		$user = $this->db->prepare("SELECT id from adreport where ad_id = :ad_id limit 1");
		//Bind parameters of SQL
		$user->bindParam(':ad_id', $params['ad_id']);
		//Execute and get result info.
		$qsent = $user->execute();
		$qerror = $user->errorInfo();
		if($qerror[0]=='00000'){
			//If is successuful verify if exist user
			$row = $user->fetch();
			error_log(json_encode($row));
			if($row)
			{
			    $data['Result'] = "OK";
			    $_SESSION['login'] = true;
			    return $data;
			}else{
				$data['Result'] = "ERROR";
				return $data;
			}
		}else{	
			//If fail return generic error message
			$data['Result'] = "ERROR";
			return $data;
		}
	}	

	function adminlogin($username,$pass){
		/**
		* Log a report User or solve error if have incorrect credentials.
		*
		* @param string $username is username
		* @param string $pass is the user password
		*/
	//Response var
	$data = array();
	//Prepare SQL

	$sql = "SELECT IdUsuario, IdRol, Contraseña from usuarios where Correo = :username  limit 1";
	$user = $this->db->prepare($sql);

	//Bind parameters of SQL
	$user->bindParam(':username', $username);
	//Execute and get result info.
	$qsent = $user->execute();
	$qerror = $user->errorInfo();
	if($qerror[0]=='00000'){
		//If is successuful verify if exist user
		$row = $user->fetch();
		error_log(json_encode($row));
		if($row)
		{   $data['Result'] = "OK";
			$data['Message'] = "Login correcto";
			$data['Detail'] = $qerror;
			$passw = $row['Contraseña'];
			if(password_verify($passw, $pass)){
				$_SESSION['login'] = true;
				$_SESSION['rol'] = $row['IdRol'];
			}else{
				$data['Result'] = "ERROR";
				$data['Message'] = "Usuario o password incorrectos";
			}
			return $data;
		}else{
			$data['Result'] = "ERROR";
			$data['Message'] = "Usuario o password incorrectos";
			$data['Detail'] = $qerror;
				return $data;
			}
		}else{
			//If fail return generic error message
			$data['Detail'] = $qerror;
			$data['Result'] = "ERROR";

			error_log(json_encode($data));
			return $data;
		}
	}



	function getUser($mobile){
		//Response var
		$data = array();
		/*Verificamos si ese email existe*/
		$user = $this->db->prepare("SELECT `id` FROM user WHERE mobile = :mobile limit 1");
		$user->bindParam(':mobile',$mobile);
		$qsent = $user->execute();
		$qerror = $user->errorInfo();
		if($qerror[0]=='00000'){
			$row = $user->fetch();
			if($row){
				$data['Result'] = "OK";
				$data['id'] = $row['id'];
			}else{
				$data['Result'] = "ERROR";
			}
		}else{
			$data['Result'] = "ERROR";
		}
		return $data;
	}


	function validateEmail($email){
		//Response var
		$data = array();
		/*Verificamos si ese email existe*/
		$user = $this->db->prepare("SELECT `name`,`email`,`enterprise`,`reference` FROM visits WHERE email = :email limit 1");
		$user->bindParam(':email',$email);
		$qsent = $user->execute();
		$qerror = $user->errorInfo();
		if($qerror[0]=='00000'){
			$row = $user->fetch();
			if($row){
				$data = $this->getCode($row['name'],$row['email'],$row['enterprise'],$row['reference']);
				$data['Name'] = $row['name'];
			}else{
				$data['Result'] = "ERROR";
			}
		}else{
			$data['Result'] = "ERROR";
		}
		return $data;
	}
	
}
?>
