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



    // SQL query to update data
    $deleteQuery = "DELETE FROM student WHERE id=$id";
       

    if (mysqli_query($connection, $deleteQuery)) {
        echo "Record Deleted successfully";
        header('Location: view.php');
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }

    mysqli_close($connection);     

