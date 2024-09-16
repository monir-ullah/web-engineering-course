<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<?php 

    // Database connection
    $server_name = 'localhost';
    $user_name = 'root';
    $password = '';
    $db_name = 'web_engineering';  // Replace with your actual database name
    

    // Create connection
    $connection = mysqli_connect($server_name, $user_name, $password, $db_name);

    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Assume the user id to search for is passed as a GET parameter
    $id = $_GET['id'];



    // SQL query to find user by id
    $sql = "SELECT * FROM student WHERE id = ?";

    // Prepare the statement
    if ($stmt = mysqli_prepare($connection, $sql)) {
        // Bind the id parameter to the SQL query
        mysqli_stmt_bind_param($stmt, "i", $id); // "i" means integer

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Fetch the result
        $result = mysqli_stmt_get_result($stmt);

        $userInfo = mysqli_fetch_assoc($result);

       

    } else {
        echo "Error preparing the SQL statement.";
    }

    // Check if the form is submitted
    if (isset($_POST["submit"])) {
        $name = $_POST['name'];
        $id = $_POST['id'];
        $email = $_POST['email'];
        $image = $_FILES['image']['name'];

        // Path where the uploaded file will be stored
        $upload_dir = 'uploads/';  // Ensure this folder exists and has the correct write permissions
        $temp_file = $upload_dir . basename($image);


        // echo image

        // Move the uploaded file to the correct location
        if (move_uploaded_file($_FILES['image']['tmp_name'], $temp_file)) {
            echo "Image uploaded successfully.";
        } else {
            echo "Error uploading the image.";
        }

        // SQL query to update data
        $updateQuery = $image? "UPDATE student SET name = '$name', email = '$email', image = '$image' WHERE id = $id" : "UPDATE student SET name = '$name', email = '$email' WHERE id = $id"; 
       

        if (mysqli_query($connection, $updateQuery)) {
            echo "Record updated successfully";
            header('Location: view.php');
        } else {
            echo "Error updating record: " . mysqli_error($connection);
        }
        
        // Close connection
                             
    }

    mysqli_close($connection);     
?>

    
   <div class="container">


            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light p-4">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="http://localhost/web-engineering/view.php">View</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"  href="http://localhost/web-engineering/create.php">Create</a>
                            </li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-3"></div>
            </div>

           <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                    
                   

                    <?php 
                    
                        if(!$userInfo){
                            echo "<h1>No user found with ID:" . $id . "</h1>";
                        }else{
                            ?>
                                 <h1 class="text-center mt-5">Edit Form Form</h1>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp"  value="<?php echo $userInfo['name'];  ?>">
                                        <input type="hidden" name="id" class="form-control" id="id" aria-describedby="emailHelp"  value="<?php echo $userInfo['id'];  ?>">
                                        
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" value="<?php  echo $userInfo['email'];?>" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Email</label>
                                        <input type="file" name="image" class="form-control" id="image" value=""> <img src="<?php  echo 'uploads/'. $userInfo['image']; ?>" alt="" style="width: 50px; border-radius: 50%; height: 50px; " class="mt-2" >
                                    </div>
                                    
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                </form>

                            <?php
                        }
                    
                    ?>


                </div>
            <div class="col-3"></div>
           </div>
   </div>

</body>
</html>