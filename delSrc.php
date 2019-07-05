<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname= 'sources';
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    $S=$_POST['SNo'];

    $sql = "DELETE FROM sources WHERE SNo =".$S."";
    
    if ($conn->query($sql) === TRUE) {
        echo "Camera Removed Successfully";
        echo '<meta http-equiv="refresh" content="1;url=index.php">'; 
    } else {
        echo "Error deleting Camera: " . $conn->error;
        echo '<meta http-equiv="refresh" content="3;url=index.php">';
    }
    
?>