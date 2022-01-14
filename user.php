<?php
	// Connect to database
	include("db_connect.php");
	
	$request_method = $_SERVER["REQUEST_METHOD"];
	
	function getUser($id=null, $query=null)
	{

		global $mysqlClient;

		$stmt = $mysqlClient->prepare('SELECT * FROM users');
		$params = [];
		

		if($query != null){
			$stmt = $mysqlClient->prepare('SELECT * FROM users WHERE firstname LIKE :query OR lastname LIKE :query');
			$params = ['query' =>'%'. $query.'%'];
		}

		if($id != null)
		{
			$stmt = $mysqlClient->prepare('SELECT * FROM users WHERE id=:id');
			$params = ['id' => $id];
		}


		$stmt->execute($params); 
		$response = $stmt->fetchAll(PDO::FETCH_ASSOC);

		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);

	}
	
	function AddUser()
	{
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		global $mysqlClient;
		$stmt = $mysqlClient->prepare('INSERT INTO users(firstname, lastname) VALUES(:firstname, :lastname)');
		$params = ['firstname' => $firstname, 'lastname' => $lastname];

		
		$stmt->execute($params); 

		header('Content-Type: application/json');
		echo json_encode("{ status: created }", JSON_PRETTY_PRINT);
	}
	
	function updateUser($id)
	{
		global $mysqlClient;

		$_PUT = array();
		parse_str(file_get_contents('php://input'), $_PUT);
		$firstname = $_PUT["firstname"];
		$lastname = $_PUT["lastname"];
		$stmt = $mysqlClient->prepare('UPDATE users SET firstname=:firstname, lastname=:lastname WHERE id=:id');
		$params = ['firstname' => $firstname, 'lastname' => $lastname, 'id' => $id];
		
		$stmt->execute($params); 

		header('Content-Type: application/json');
		echo json_encode("{ status: updated }", JSON_PRETTY_PRINT);
	}
	
	function deleteUser($id)
	{
		global $mysqlClient;

		$stmt = $mysqlClient->prepare('DELETE FROM users WHERE id=:id');
		$params = ['id' => $id];
		
		$stmt->execute($params); 

		header('Content-Type: application/json');
		echo json_encode("{ status: deleted }", JSON_PRETTY_PRINT);

	}
	
	switch($request_method)
	{
		
		case 'GET':
			// Retrieve Users
			$id=null;
			$query=null;
			$from=null;
			$to=null;
			
			if(!empty($_GET["id"]))
			{
				if (!ctype_digit($_GET['id'])) {
					header('Content-Type: application/json');
					echo json_encode('{ error: invalid_id }', JSON_PRETTY_PRINT);
					return false;
				} else {
					$id = (int)$_GET['id'];
				}
				
			}

			if(!empty($_GET["query"]))
			{
				$query=$_GET["query"];	
			}


			getUser($id, $query);
			break;
			
		case 'POST':
			// Ajouter un produit
			AddUser();
			break;
			
		case 'PUT':
			// Modifier un produit
			$id = intval($_GET["id"]);
			updateUser($id);
			break;
			
		case 'DELETE':
			// Supprimer un produit
			$id = intval($_GET["id"]);
			deleteUser($id);
			break;
		
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;

	}
?>