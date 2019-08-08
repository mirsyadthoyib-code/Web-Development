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
		!empty($data->description)&&
		!empty($data->address)&&
		!empty($data->deto)
	){
	 
		// set product property values
		$product->name = $data->name;
		$product->description = $data->description;
		$product->address = $data->address;
		$product->deto = $data->deto;
		
		if($product->report_user()){
	 
		// set response code - 200 ok
			http_response_code(200);
		 
			// tell the user
			echo json_encode(array("message" => "Report was success."));
		}
	}
	 
	// if unable to update the product, tell the user
	else{
	 
		// set response code - 503 service unavailable
		http_response_code(503);
	 
		// tell the user
		echo json_encode(array("message" => "failed to report"));
	}
?>
