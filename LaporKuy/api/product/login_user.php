<?php
	// required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	 
	// include database and object files
	//include_once 'C:/xampp/htdocs/rpl_api_ubuntu/api/config/database.php';
	//include_once 'C:/xampp/htdocs/rpl_api_ubuntu/objects/product.php';
	//include_once '../config/database.php';
	//include_once '/opt/lampp/htdocs/rpl_api_ubuntu/objects/product.php';	 
	 
	include_once '../config/database.php';
	include_once 'C:/xampp/htdocs/LaporKuy/objects/product.php';

	$database = new Database();
	$db = $database->getConnection();
	 
	$product = new Product($db);
	 
	// get posted data
	$data = json_decode(file_get_contents("php://input"));
	 
	// make sure data is not empty
	if(
		!empty($data->name) &&
		!empty($data->password)
	){
	 
		// set product property values
		$product->name = $data->name;
		$product->password = $data->password;
		
		$stmt = $product->login_user();
		$num = $stmt->rowCount();
		
		// create the product
		if($num>0){
	 
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		 		extract($row);
			}
			// set response code - 201 created
			http_response_code(201);
	 
			// tell the user
			$product_arr=array(
				"ktp" => $ktp,
				"message" => "success login"
			);
			echo json_encode($product_arr);
		}
	 
		// if unable to create the product, tell the user
		else{
	 
			// set response code - 503 service unavailable
			http_response_code(503);
	 
			// tell the user
			echo json_encode(array("message" => "failed login"));
		}
	}
	 
	// tell the user data is incomplete
	else{
	 
		// set response code - 400 bad request
		http_response_code(400);
	 
		// tell the user
		echo json_encode(array("message" => "failed login"));
	}
?>
