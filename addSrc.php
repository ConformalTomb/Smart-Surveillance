<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sources";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $name=$_POST['Name'];
    $url=$_POST['URL'];

    $sql='INSERT INTO sources (Name,Link) VALUES ("'.$name.'","'.$url.'")';

    if ($conn->query($sql) === TRUE) {
        echo "Link Added Succesfully";
        echo '<meta http-equiv="refresh" content="0;url=index.php">';
        }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        echo '<meta http-equiv="refresh" content="20;url=index.php">';
    }
    
    $conn->close();
						
?>