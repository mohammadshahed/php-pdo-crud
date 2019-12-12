<!DOCTYPE html>
<html lang="en">
<head>
  <title>Php CRUD with PDO</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<body>

	<!-- container -->
    <div class="container">
  
        <div class="page-header">
            <h1>Update Product</h1>
        </div>
         
        <!-- PHP read one record will be here -->
        <?php
			// get passed parameter value, in this case, the record ID
			// isset() is a PHP function used to verify if a value is there or not
			$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
			 
			//include database connection
			include 'config/database.php';
			 
			// read current record's data
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
       
       <?php
 			
 			include 'config/database.php';
			// check if form was submitted
			if($_POST){
			     


			    try{
			     
			        // write update query
			        // in this case, it seemed like we have so many fields to pass and 
			        // it is better to label them and not use question marks
			        $query = "UPDATE products 
			                    SET name=:name, description=:description, price=:price 
			                    WHERE id = :id";
			 
			        // prepare query for excecution
			        $stmt = $con->prepare($query);
			 
			        // posted values
			        $name=htmlspecialchars(strip_tags($_POST['name']));
			        $description=htmlspecialchars(strip_tags($_POST['description']));
			        $price=htmlspecialchars(strip_tags($_POST['price']));
			 
			        // bind the parameters
			        $stmt->bindParam(':name', $name);
			        $stmt->bindParam(':description', $description);
			        $stmt->bindParam(':price', $price);
			        $stmt->bindParam(':id', $id);
			         
			        // Execute the query
			        if($stmt->execute()){
			            echo "<div class='alert alert-success'>Record was updated.</div>";
			        }else{
			            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
			        }
			         
			    }
			     
			    // show errors
			    catch(PDOException $exception){
			        die('ERROR: ' . $exception->getMessage());
			    }
			}
		?>
 		
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id={$id}');?>" method="post">
		    <table class='table table-bordered'>
		        <tr>
		            <th>Name</th>
		            <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
		        </tr>
		        <tr>
		            <th>Description</th>
		            <td><textarea name='description' class='form-control'><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea></td>
		        </tr>
		        <tr>
		            <th>Price</th>
		            <td><input type='text' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES);  ?>" class='form-control' /></td>
		        </tr>
		        <tr>
		            <td></td>
		            <td>
		                <input type='submit' value='Save Changes' class='btn btn-primary' />
		                <a href='index.php' class='btn btn-info'>Back to read products</a>
		            </td>
		        </tr>
		    </table>
		</form>

		



		        
    </div> <!-- end .container -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</body>
</html> 