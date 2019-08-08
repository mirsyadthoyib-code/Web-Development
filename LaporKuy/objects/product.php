 <?php
	class Product{
	 
		// database connection and table name
		private $conn;
		private $table_name = "reportinbox";
		private $table_user = "registrasi";
		private $table_user_list = "newregistration";
		private $table_report = "reportfeedback";
	 
		// object properties
		public $id;
		public $ktp;
		public $name;
		public $title;
		public $description;
		public $latitude;
		public $longtitude;
		public $address;
		public $deto;
		public $proceed;
		public $wasRead;
		public $finish;

		public $password;
		
		// constructor with $db as database connection
		public function __construct($db){
			$this->conn = $db;
		}
		
		function countRow(){
			$query = "select count(*) from " . $this->table_name;
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
		}
		
		function read(){
		 
			// select all query
			$query = "SELECT * FROM " . $this->table_name . " where deto > :deto " . " ORDER BY deto DESC limit 50";
		 	
			// prepare query statement
			$stmt = $this->conn->prepare($query);
		 
			$this->deto=htmlspecialchars(strip_tags($this->deto));
			$stmt->bindParam(':deto', $this->deto);

			// execute query
			$stmt->execute();
		 
			return $stmt;
		}
		
		function readOne(){
		 
			// query to read single record
			$query = "SELECT * FROM " . $this->table_name . " WHERE deto = :deto"."";
		 	
			// prepare query statement
			$stmt = $this->conn->prepare($query);
		 
			$this->deto=htmlspecialchars(strip_tags($this->deto));
			$stmt->bindParam(':deto', $this->deto);

			// execute query
			$stmt->execute();
		 
			return $stmt;
		}

		function readOneNT(){
		 
			// query to read single record
			$query = "SELECT * FROM " . $this->table_name . " where ktp=:ktp and name=:name and title=:title and description=:description and latitude=:latitude and longtitude=:longtitude and address=:address limit 1";
		 
		 	$stmt = $this->conn->prepare($query);
			
			$this->ktp=htmlspecialchars(strip_tags($this->ktp));
			$this->name=htmlspecialchars(strip_tags($this->name));
			$this->title=htmlspecialchars(strip_tags($this->title));
			$this->description=htmlspecialchars(strip_tags($this->description));
			$this->latitude=htmlspecialchars(strip_tags($this->latitude));
			$this->longtitude=htmlspecialchars(strip_tags($this->longtitude));
			$this->address=htmlspecialchars(strip_tags($this->address));
			
			// bind values
			$stmt->bindParam(":ktp", $this->ktp);
			$stmt->bindParam(":name", $this->name);
			$stmt->bindParam(":title", $this->title);
			$stmt->bindParam(":description", $this->description);
			$stmt->bindParam(":latitude", $this->latitude);
			$stmt->bindParam(":longtitude", $this->longtitude);
			$stmt->bindParam(":address", $this->address);

			// execute query
			$stmt->execute();
		 
			return $stmt;
		}

		// create product
		function create(){
		 
			// query to insert record
			$query = "INSERT INTO " . $this->table_name . " SET ktp=:ktp, name=:name, title=:title, description=:description, latitude=:latitude, longtitude=:longtitude, address=:address";
		 
			// prepare query
			$stmt = $this->conn->prepare($query);
		 
			// sanitize
			$this->ktp=htmlspecialchars(strip_tags($this->ktp));
			$this->name=htmlspecialchars(strip_tags($this->name));
			$this->title=htmlspecialchars(strip_tags($this->title));
			$this->description=htmlspecialchars(strip_tags($this->description));
			$this->latitude=htmlspecialchars(strip_tags($this->latitude));
			$this->longtitude=htmlspecialchars(strip_tags($this->longtitude));
			$this->address=htmlspecialchars(strip_tags($this->address));
			
			// bind values
			$stmt->bindParam(":ktp", $this->ktp);
			$stmt->bindParam(":name", $this->name);
			$stmt->bindParam(":title", $this->title);
			$stmt->bindParam(":description", $this->description);
			$stmt->bindParam(":latitude", $this->latitude);
			$stmt->bindParam(":longtitude", $this->longtitude);
			$stmt->bindParam(":address", $this->address);
			
			// execute query
			if($stmt->execute()){
				return true;
			}
		 
			return false;
		}
		
		function login_user(){
		 
			// query to read single record
			$query = "SELECT * FROM " . $this->table_user_list . " where name=:name and password=:password " . "limit 50";
		 
			// prepare query statement
			$stmt = $this->conn->prepare($query);
		 
			$this->name=htmlspecialchars(strip_tags($this->name));
			$this->password=htmlspecialchars(strip_tags($this->password));
			$stmt->bindParam(':name', $this->name);
			$stmt->bindParam(':password', $this->password);

			// execute query
			$stmt->execute();
		 
			return $stmt;
		}

		// create user
		function create_user(){
		 
			// query to insert record
			$query = "INSERT INTO " . $this->table_user . " SET ktp=:ktp, latitude=:latitude, longtitude=:longtitude";
		 
			// prepare query
			$stmt = $this->conn->prepare($query);
		 
			// sanitize
			$this->ktp=htmlspecialchars(strip_tags($this->ktp));	
			$this->latitude=htmlspecialchars(strip_tags($this->latitude));
			$this->longtitude=htmlspecialchars(strip_tags($this->longtitude));
			
			// bind values
			$stmt->bindParam(":ktp", $this->ktp);
			$stmt->bindParam(":latitude", $this->latitude);
			$stmt->bindParam(":longtitude", $this->longtitude);
			
			// execute query
			if($stmt->execute()){
				return true;
			}
		 
			return false;
		}
		
		function register_user(){
			// query to insert record
			$query = "INSERT INTO " . $this->table_user_list . " SET name=:name, ktp=:ktp, password=:password";
		 
			// prepare query
			$stmt = $this->conn->prepare($query);
		 
			// sanitize
			$this->ktp=htmlspecialchars(strip_tags($this->ktp));	
			$this->name=htmlspecialchars(strip_tags($this->name));
			$this->password=htmlspecialchars(strip_tags($this->password));
			
			// bind values
			$stmt->bindParam(":ktp", $this->ktp);
			$stmt->bindParam(":name", $this->name);
			$stmt->bindParam(":password", $this->password);
			
			// execute query
			if($stmt->execute()){
				return true;
			}
		 
			return false;
		}

		// update the user
		function update_user(){
		 
			// update query
			$query = "UPDATE " . $this->table_user . " SET latitude = :latitude, longtitude = :longtitude
					WHERE
						ktp = :ktp";
		 
			// prepare query statement
			$stmt = $this->conn->prepare($query);
		 
			// sanitize
			$this->ktp=htmlspecialchars(strip_tags($this->ktp));
			$this->latitude=htmlspecialchars(strip_tags($this->latitude));
			$this->longtitude=htmlspecialchars(strip_tags($this->longtitude));
			
			// bind new values
			$stmt->bindParam(':ktp', $this->ktp);
			$stmt->bindParam(':latitude', $this->latitude);
			$stmt->bindParam(':longtitude', $this->longtitude);
		 
			// execute the query
			if($stmt->execute()){
				return true;
			}
		 
			return false;
		}

		function report_user(){
		 
			// update query
			$query = "INSERT INTO " . $this->table_report . " SET name=:name, description=:description, address=:address, deto=:deto";
		 
			// prepare query statement
			$stmt = $this->conn->prepare($query);
		 
			// sanitize
			$this->name=htmlspecialchars(strip_tags($this->name));
			$this->description=htmlspecialchars(strip_tags($this->description));
			$this->address=htmlspecialchars(strip_tags($this->address));
			$this->deto=htmlspecialchars(strip_tags($this->deto));
			
			// bind new values
			$stmt->bindParam(':name', $this->name);
			$stmt->bindParam(':description', $this->description);
			$stmt->bindParam(':address', $this->address);
			$stmt->bindParam(':deto', $this->deto);
		 
			// execute the query
			if($stmt->execute()){
				return true;
			}
		 
			return false;
		}

		// update the product
		function update(){
		 
			// update query
			$query = "UPDATE
						" . $this->table_name . "
					SET
						name = :name,
						price = :price,
						description = :description,
						category_id = :category_id
					WHERE
						id = :id";
		 
			// prepare query statement
			$stmt = $this->conn->prepare($query);
		 
			// sanitize
			$this->name=htmlspecialchars(strip_tags($this->name));
			$this->price=htmlspecialchars(strip_tags($this->price));
			$this->description=htmlspecialchars(strip_tags($this->description));
			$this->category_id=htmlspecialchars(strip_tags($this->category_id));
			$this->id=htmlspecialchars(strip_tags($this->id));
		 
			// bind new values
			$stmt->bindParam(':name', $this->name);
			$stmt->bindParam(':price', $this->price);
			$stmt->bindParam(':description', $this->description);
			$stmt->bindParam(':category_id', $this->category_id);
			$stmt->bindParam(':id', $this->id);
		 
			// execute the query
			if($stmt->execute()){
				return true;
			}
		 
			return false;
		}
		
		// delete the product
		function delete(){
		 
			// delete query
			$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
		 
			// prepare query
			$stmt = $this->conn->prepare($query);
		 
			// sanitize
			$this->id=htmlspecialchars(strip_tags($this->id));
		 
			// bind id of record to delete
			$stmt->bindParam(1, $this->id);
		 
			// execute query
			if($stmt->execute()){
				return true;
			}
		 
			return false;
			 
		}
		
		function search($keywords){
			// select all query
			$query = "SELECT
						c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
					FROM
						" . $this->table_name . " p
						LEFT JOIN
							categories c
								ON p.category_id = c.id
					WHERE
						p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
					ORDER BY
						p.created DESC";
		 
			// prepare query statement
			$stmt = $this->conn->prepare($query);
		 
			// sanitize
			$keywords=htmlspecialchars(strip_tags($keywords));
			$keywords = "%{$keywords}%";
		 
			// bind
			$stmt->bindParam(1, $keywords);
			$stmt->bindParam(2, $keywords);
			$stmt->bindParam(3, $keywords);
		 
			// execute query
			$stmt->execute();
		 
			return $stmt;
		}
	}
?>
