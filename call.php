<?php
    $flag = $_POST['flag'];

        if($flag == 1)
        {

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname= 'sources';
                
                $conn = new mysqli($servername, $username, $password, $dbname);

                $sql = "SELECT Link FROM sources";
                $result = $conn->query($sql);

            if ($result->num_rows > 0) 
            {
                $str='';
                while($row = $result->fetch_assoc()) {
                    $str=$str.''.$row['Link'].' ';
                }
                set_time_limit(0);
                $command = escapeshellcmd('python recognize_faces_video.py --encodings encodings1.pickle -d hog --src '.$str.'');
                shell_exec($command);
                echo 'You will be redirected shortly!
                <meta http-equiv="refresh" content="3;url=index.php">';
                
            } 
                else 
                {
                    echo "No Camera Added";
                    echo '<meta http-equiv="refresh" content="3;url=index.php">';
                }
        }

        elseif ($flag == 2) 
        {
            echo'
            <form action="" method="post" enctype="multipart/form-data">
            Select image to upload:
                <input type="hidden" name = "flag" value="2">
                <input type="hidden" name = "person" value='.$_POST['person'].'>
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" value="Upload Image" name="submit">
            </form>
            <a href="index.php"">Return to Home</a>';
            $target_dir = 'ReveDataset/'.$_POST['person']."/";
            $a = sizeof(scandir($target_dir))-2;
            $target_file = $target_dir . basename('00'.$a.'.jpg');
            $uploadOk = 1;
            if ($_FILES) 
            {   
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }
                }
                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else 
                {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
                    {
                        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                        $myfile = fopen("info.txt", "w") or die("Unable to open file!");
                        $txt = "Y";
                        fwrite($myfile, $txt);
                        fclose($myfile);
                    } else {
                        echo "Sorry, there was an error uploading your file. Please Try Again";
                    }
                }
            }
        }

        elseif ($flag ==3) {            
            echo'
            <form action="" method="post" enctype="multipart/form-data">
            Select image to upload:
                <input type="hidden" name = "flag" value="3">
                <label>Enter name of Person: <input type="text" name = "person" required></label><br>
                <input type="file" name="fileToUpload" id="fileToUpload" required><br>
                <input type="submit" value="Upload Image" name="submit">
            </form>
            <a href="index.php"">Return to Home</a>';
 
            if ($_FILES) 
            {   
                $d = getcwd();
                $d = $d."\ReveDataset\\";
                $command = escapeshellcmd('mkdir '.$d.$_POST['person']);
                $output = shell_exec($command);
                $target_dir = 'ReveDataset/'.$_POST['person']."/";
                $a = sizeof(scandir($target_dir))-2;
                $target_file = $target_dir . basename('00'.$a.'.jpg');
                $uploadOk = 1;   
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    // Check if image file is a actual image or fake image
                    if(isset($_POST["submit"])) {
                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                        if($check !== false) {
                            echo "File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                        } else {
                            echo "File is not an image.";
                            $uploadOk = 0;
                        }
                    }
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        echo "Sorry, file already exists.";
                        $uploadOk = 0;
                    }
                    // Check file size
                    if ($_FILES["fileToUpload"]["size"] > 500000) {
                        echo "Sorry, your file is too large.";
                        $uploadOk = 0;
                    }
                    // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                    } else 
                    {
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
                        {
                            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                            $myfile = fopen("info.txt", "w") or die("Unable to open file!");
                            $txt = "Y";
                            fwrite($myfile, $txt);
                            fclose($myfile);
                        } else {
                            echo "Sorry, there was an error uploading your file. Please Try Again";
                        }
                    }
                }
            }        
    


?>
