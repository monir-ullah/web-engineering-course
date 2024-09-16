<?php 



    $server_name = 'localhost';
    $user_name = 'root';
    $password = '';

    $connection =  mysqli_connect($server_name, $user_name, $password);


    ?>

    <pre>
        <?php 
        
            


        if($connection === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        ?>
    </pre>


    <?php


