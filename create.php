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

<div class="container">
        <div class="page-header ">
            <h1>Create Product</h1>
        </div>

	   <?php
			if(isset($_POST)){
 
			    // include database connection
			    include 'config/database.php';
			 
			    try{
			        $query = "INSERT INTO products SET name=:name, description=:description, price=:price, created=:created";
			        $stmt = $con->prepare($query);
			 
			        // posted values
			        $name=htmlspecialchars(strip_tags($_POST['name']));
			        $description=htmlspecialchars(strip_tags($_POST['description']));
			        $price=htmlspecialchars(strip_tags($_POST['price']));
			 
			        // bind the parameters
			        $stmt->bindParam(':name', $name);
			        $stmt->bindParam(':description', $description);
			        $stmt->bindParam(':price', $price);
			         
			        // specify when this record was inserted to the database
			        $created=date('Y-m-d H:i:s');
			        $stmt->bindParam(':created', $created);
			         
			        // Execute the query
			        if($stmt->execute()){
			            echo "<div class='alert alert-success'>Record was saved.</div>";
			        }
			        else{
			            echo "<div class='alert alert-danger'>Unable to save record.</div>";
			        }
			         
			    }
			     
			    // show error
			    catch(PDOException $exception){
			        die('ERROR: ' . $exception->getMessage());
			    }
			}
		?>
	 
    <div class="row justify-content-center">
    	
	    	<!-- html form here where the product information will be entered -->
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"> 
		    <table class='table'>
		        <tr>
		            <th>Name</th>
		            <td><input type='text' name='name' class='form-control' /></td>
		        </tr>
		        <tr>
		            <th>Description</th>
		            <td><textarea name='description' class='form-control'></textarea></td>
		        </tr>
		        <tr>
		            <th>Price</th>
		            <td><input type='text' name='price' class='form-control' /></td>
		        </tr>
		        <tr>
		            <td></td>
		            <td>
		                <input type='submit' name='submit' value='Save' class='btn btn-primary' />
		                <a href='index.php' class='btn btn-info'>Back to read products</a>
		            </td>
		        </tr>
		    </table>
		</form>

    </div>


	


</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

</body>
</html> 




