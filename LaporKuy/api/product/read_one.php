<?php
	// required headers
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: access");
	header("Access-Control-Allow-Methods: GET");
	header("Access-Control-Allow-Credentials: true");
	header('Content-Type: application/json');
	 
	// include database and object files
	//include_once 'C:/xampp/htdocs/rpl_api_ubuntu/api/config/database.php';
	//include_once 'C:/xampp/htdocs/rpl_api_ubuntu/objects/product.php';
	//include_once '../config/database.php';
	//include_once '/opt/lampp/htdocs/rpl_api_ubuntu/objects/product.php';	 
	
	//include_once 'C:/xampp/htdocs/LaporKuy/rpl_api_ubuntu/api/config/database.php';
	//include_once 'C:/xampp/htdocs/LaporKuy/rpl_api_ubuntu/objects/product.php';
	
	include_once '../config/database.php';
	include_once 'C:/xampp/htdocs/LaporKuy/objects/product.php';
	 
	// get database connection
	$database = new Database();
	$db = $database->getConnection();
	 
	// prepare product object
	$product = new Product($db);
	 
	$data = json_decode(file_get_contents("php://input"));

	if(empty($data->deto)){
		echo json_encode(array("message" => "Bakana koto yuuna yo teme"));
	}
	else{
		$product->deto = $data->deto;
	}
	 
	// read the details of product to be edited
	$stmt = $product->readOne();
	$num = $stmt->rowCount();
	 
	if($num>0){
	 
		// products array
		$products_arr=array();
		$products_arr["records"]=array();
	 
		// retrieve our table contents
		// fetch() is faster than fetchAll()
		// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			// extract row
			// this will make $row['name'] to
			// just $name only
			extract($row);
	 
			$product_item=array(
				"id" => $id,
				"ktp" => $ktp,
				"name" => $name,
				"description" => $description,
				"latitude" => $latitude,
				"longtitude" => $longtitude,
				"address" => $address,
				"deto" => $deto,
				"title" => $title,
				"proceed" => $proceed,
				"wasRead" => $wasRead,
				"finish" => $finish
			);
	 
			array_push($products_arr["records"], $product_item);
		}
	 
		// set response code - 200 OK
		http_response_code(200);
	 
		// show products data in json format
		echo json_encode($products_arr);
	}
	 
	else{
		// set response code - 404 Not found
		http_response_code(404);
	 
		// tell the user product does not exist
		echo json_encode(array("message" => "Product does not exist."));
	}
?>