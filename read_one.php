<!DOCTYPE html>
<html lang="en">
<head>
  <title>Php CRUD with PDO</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>

	<!-- container -->
    <div class="container">
  
        <div class="page-header">
            <h1>Read Product</h1>
        </div>
               
        <?php

			$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
			 

			include 'config/database.php';
			 
			try {
			    // prepare select query
			    $query = "SELECT id, name, description, price FROM products WHERE id = ? LIMIT 0,1";
			    $stmt = $con->prepare( $query );
			 
			    // this is the first question mark
			    $stmt->bindParam(1, $id);
			 
			    // execute our query
			    $stmt->execute();
			 
			    // store retrieved row to a variable
			    $row = $stmt->fetch(PDO::FETCH_ASSOC);
			 
			    // values to fill up our form
			    $name = $row['name'];
			    $description = $row['description'];
			    $price = $row['price'];
			}
			 
			// show error
			catch(PDOException $exception){
			    die('ERROR: ' . $exception->getMessage());
			}
		?>
 
        
		<table class='table full-width table-bordered'>
		    <tr>
		        <th>Name</th>
		        <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
		    </tr>
		    <tr>
		        <th>Description</th>
		        <td><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></td>
		    </tr>
		    <tr>
		        <th>Price</th>
		        <td><?php echo htmlspecialchars($price, ENT_QUOTES);  ?></td>
		    </tr>
		    <tr>
		        <td></td>
		        <td>
		            <a href='index.php' class='btn btn-info'>Back to read products</a>
		        </td>
		    </tr>
		</table>
 
    </div> <!-- end .container -->

</body>
</html> 

