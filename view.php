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

    $sql = 'SELECT * FROM  student';

    $result = mysqli_query($connection, $sql);


    if(mysqli_num_rows($result)<=0){
        echo 'Data not found!';

        die();
    } 



    if(!$result){
        echo 'Data not found!';
        die();
    }
    // echo $result->field_count;

    // var_dump($result[num_rows]);
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
            <div class="col-2"></div>
            <div class="col-8">
                    
                    <h1 class="text-center mt-5">View Student List</h1>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Profile</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            // $singleInfo = mysqli_fetch_assoc($result);
                            
                            // var_dump($singleInfo);


                            while($singleInfo = mysqli_fetch_assoc($result)){
                                ?>

                                    <tr>
                                        <th scope="row"><?php echo $singleInfo['id']; ?></th>
                                        <td><?php echo $singleInfo['name']; ?></td>
                                        <td><?php echo $singleInfo['email']; ?></td>
                                        <td><img src="<?php  echo 'uploads/'. $singleInfo['image']; ?>" alt="<?php // echo $singleInfo['name']; ?>" style="width: 50px; border-radius: 50%; height: 50px;"></td>
                                        <td><a href="<?php echo 'edit.php?id='. $singleInfo['id'] ?>" class="btn btn-danger">Edit</a><a href="<?php echo 'delete.php?id='. $singleInfo['id'] ?>" class="btn btn-primary mx-2">Delete</a></td>
                                        </tr>

                                <?php 
                            }
                            
                            ?>
                        </tbody>    
                        </table>
                </div>
            <div class="col-2"></div>
           </div>
   </div>

</body>
</html>