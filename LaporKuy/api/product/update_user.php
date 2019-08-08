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
	 
	// get database connection
	$database = new Database();
	$db = $database->getConnection();
	 
	// prepare product object
	$product = new Product($db);
	 
	$data = json_decode(file_get_contents("php://input"));
	  
	$product->ktp = $data->ktp;
	$product->latitude = $data->latitude;
	$product->longtitude = $data->longtitude;
	 
	// update the product
	if($product->update_user()){
	 
		// set response code - 200 ok
		http_response_code(200);
	 
		// tell the user
		echo json_encode(array("message" => "Product was updated."));
	}
	 
	// if unable to update the product, tell the user
	else{
	 
		// set response code - 503 service unavailable
		http_response_code(503);
	 
		// tell the user
		echo json_encode(array("message" => "Unable to update product."));
	}
?>
