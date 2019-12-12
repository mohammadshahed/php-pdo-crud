<!DOCTYPE html>
<html lang="en">
<head>
  <title>Php CRUD with PDO</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


   <!-- custom css -->
    <style>
	    .m-r-1em{ margin-right:1em; }
	    .m-b-1em{ margin-bottom:1em; }
	    .m-l-1em{ margin-left:1em; }
	    .mt0{ margin-top:0; }
    </style>

</head>
<body>

<div class="container">
        <div class="page-header">
            <h1>Read Products</h1>
        </div>

	<?php   
	   $action = isset($_GET['action']) ? $_GET['action'] : "";
		 
		// if it was redirected from delete.php
		if($action=='deleted'){
		    echo "<div class='alert alert-success'>Record was deleted.</div>";
		}
	?>

	   <?php
			// include database connection
			include 'config/database.php';
			
			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$records_per_page = 5;			 
			$from_record_num = ($records_per_page * $page) - $records_per_page;
			 
			// delete message prompt will be here
			 
			
			$query = "SELECT id, name, description, price FROM products ORDER BY id DESC
			    LIMIT :from_record_num, :records_per_page";
			 
			$stmt = $con->prepare($query);
			$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
			$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
			$stmt->execute();			
			$num = $stmt->rowCount();	

			echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";
			 
			//check if more than 0 record found
			if($num>0){
			 
			    // data from database will be here
			    echo "<table class='table table-hover table-bordered'>";				    
				    echo "<tr>";
				        echo "<th>ID</th>";
				        echo "<th>Name</th>";
				        echo "<th>Description</th>";
				        echo "<th>Price</th>";
				        echo "<th>Action</th>";
				    echo "</tr>";
				     
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					    extract($row);
					     
					    echo "<tr>";
					        echo "<td>{$id}</td>";
					        echo "<td>{$name}</td>";
					        echo "<td>{$description}</td>";
					        echo "<td>&#36;{$price}</td>";
					        echo "<td>";
					            // read one record 
					            echo "<a href='read_one.php?id={$id}' class='btn btn-info m-r-1em'>Read</a>";
					             
					            // we will use this links on next part of this post
					            echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'>Edit</a>";
					 
					            // we will use this links on next part of this post
					            echo "<a href='#' onclick='delete_user({$id});'  class='btn btn-danger'>Delete</a>";
					        echo "</td>";
					    echo "</tr>";
					}
				 
				// end table
				echo "</table>";

				// count total number of rows
				$query = "SELECT COUNT(*) as total_rows FROM products";
				$stmt = $con->prepare($query);
				 
				// execute query
				$stmt->execute();
				 
				// get total rows
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$total_rows = $row['total_rows'];

				
			     
			}
			 
			// if no records found
			else{
			    echo "<div class='alert alert-danger'>No records found.</div>";
			}


			// paginate records
				$page_url="index.php?";
				include_once "paging.php";
			
		?>
	 
	
</div>


<script type='text/javascript'>
// confirm record deletion
function delete_user( id ){
     
    var answer = confirm('Are you sure?');
    if (answer){
        // if user clicked ok, 
        // pass the id to delete.php and execute the delete query
        window.location = 'delete.php?id=' + id;
    } 
}
</script>





<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

</body>
</html> 

