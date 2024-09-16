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

// Check if the form is submitted
if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $image = $_FILES['image']['name'];

    // Path where the uploaded file will be stored
    $upload_dir = 'uploads/';  // Ensure this folder exists and has the correct write permissions
    $temp_file = $upload_dir . basename($image);

    // Move the uploaded file to the correct location
    if (move_uploaded_file($_FILES['image']['tmp_name'], $temp_file)) {
        echo "Image uploaded successfully.";
    } else {
        echo "Error uploading the image.";
    }

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

    // Prepared statement to prevent SQL injection
    $sql = $connection->prepare("INSERT INTO student (name, email, image) VALUES (?, ?, ?)");

    ?>
        <pre>
            <?php var_dump($sql)?>
        </pre>
    <?php

    // die();
    $sql->bind_param("sss", $name, $email, $image);

    // Execute the query
    if ($sql->execute()) {
        echo 'Records inserted successfully.';
        header("Location: http://localhost/web-engineering/create.php");
        exit;
    } else {
        echo "ERROR: Could not execute query. " . mysqli_error($connection);
    }

    // Close the connection
    $sql->close();
    mysqli_close($connection);
}
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
                    
                    <h1 class="text-center mt-5">Registration Form</h1>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Email</label>
                            <input type="file" name="image" class="form-control" id="image">
                        </div>
                        
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            <div class="col-3"></div>
           </div>
   </div>

</body>
</html>