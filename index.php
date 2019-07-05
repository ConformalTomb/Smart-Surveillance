<html>
<head>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <title>Home</title>
</head> 
<body>
<?php 
        $myfile = fopen("info.txt", "r") or die("Unable to open file!");
        if(fgets($myfile)=='Y')
        {                  
                $command = escapeshellcmd('python encode_faces.py --dataset ReveDataset --encodings encodings1.pickle');
                $output = shell_exec($command);
                fclose($myfile);
                $myfile = fopen("info.txt", "w") or die("Unable to open file!");
                        $txt = "N";
                        fwrite($myfile, $txt);
                        fclose($myfile);
                echo '<meta http-equiv="refresh" content="0"/>';
        }
        else {
                fclose($myfile);
        }
?>
    <div class='container'>
        <div class="row">
                <div class="col s12 m6 l4">
                        <div class="card blue darken-1">
                                <div class="card-content white-text">
                                        <span class="card-title"><b>Initiate Facial Recognition using webcam</b></span>
                                        <form action='call.php' method = 'post'>

                                                <input type = 'hidden' name='flag' value = '1'>
                                               <fieldset style='border-color: white;'><legend class ='white-text'>Detectable Faces</legend>
                                                        <?php
                                                                $d = "ReveDataset";
                                                                $entries = scandir($d);
                                                                $filelist = array();
                                                                foreach ($entries as $entry) {
                                                                        if(!is_dir($entry))
                                                                        {       
                                                                                if ($handle = opendir('ReveDataset/'.$entry)) {
                                                                                        while ($e = readdir($handle)) {
                                                                                                if (strpos($e, '00') === 0) {
                                                                                                $iName = $e;
                                                                                                echo '
                                                                                                <div class="chip">
                                                                                                <img src="ReveDataset/'.$entry.'/'.$iName.'">
                                                                                                '.$entry.'
                                                                                                </div><br>
                                                                                                ';
                                                                                                break;
                                                                                                }
                                                                                        }
                                                                                }
                                                                                closedir($handle);
                                                                               
                                                                        }                
                                                                }
                                                        ?>
                                                        
                                               </fieldset><br>
                                </div>
                                <div class="card-action">
                                                <button class="btn waves-effect waves-light" type="submit" name="action">Run Recognition<i class="material-icons right">send</i>
                                                </button>
        
                                        </form>
                                </div>
                        </div>
                </div>
                
                <div class="col s12 m6 l4">
                        <div class="card red darken-1">
                                <div class="card-content white-text">
                                        <span class="card-title"><b>Sources</b></span>
					<?php
						$servername = "localhost";
						$username = "root";
						$password = "";
						$dbname= 'sources';
						
						$conn = new mysqli($servername, $username, $password, $dbname);

						$sql = "SELECT * FROM sources";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) 
						{
						// output data of each row
						while($row = $result->fetch_assoc()) 
							{
							echo '
							<form action="delSrc.php" method="POST">
							<div class ="chip">
								'.$row['Name'].'
								<button type ="submit" class="btn-flat btn-tiny" name="SNo" value="'.$row['SNo'].'"><i class="material-icons">clear</i></button>
							</div>
							</form>
							';
							}
						} 
						else 
						{
							echo "No Camera Added";
						}
					?>
                                </div>
                                <div class="card-action">
				<form action="addSrc.php" method='POST'>
					<div class="input-field col s4">
						<input id="Name" name='Name' type="text" class="validate white-text" required>
						<label for="Name" class=" white-text">Name</label>
					</div>
					<div class="input-field col s8">
						<input id="URL" name='URL' type="text" class="white-text validate" required>
						<label for="URL" class=" white-text">URL</label>
					</div>
					<button class="btn waves-effect waves-light" type="submit" name="action">Add Camera<i class="material-icons right">camera</i>
                                        </button>
                                </form>
				</div>
                        </div>
                </div>
                
                <div class="col s12 m6 l4">
                        <div class="card green darken-1">
                                <div class="card-content white-text">
                                        <span class="card-title"><b>Create or Improve faces</b></span><br>
                                                <fieldset style='border-color: white;'><legend class ='white-text'>Improve Faces</legend>
                                                <form action = "call.php" method = "POST">
                                                        <input type="hidden" name="flag" value="2">
                                                        <?php
                                                                $d = "ReveDataset";
                                                                $entries = scandir($d);
                                                                $filelist = array();
                                                                foreach ($entries as $entry) {
                                                                        if(!is_dir($entry))
                                                                        {       
                                                                                if ($handle = opendir('ReveDataset/'.$entry)) {
                                                                                        
                                                                                        while ($e = readdir($handle)) {
                                                                                                if (strpos($e, '00') === 0) {
                                                                                                $iName = $e;
                                                                                                echo '
                                                                                                <div class="chip">
                                                                                                <img src="ReveDataset/'.$entry.'/'.$iName.'">
                                                                                                '.$entry.'
                                                                                                </div>
                                                                                                <button class="btn right waves-effect waves-light deep-purple darken-1" type="submit" name="person" value='.$entry.'>Add<i class="material-icons right">add</i>
                                                                                                </button>
                                                                                                ';
                                                                                                break;
                                                                                                }
                                                                                        }
                                                                                        
                                                                                }
                                                                                closedir($handle);
                                                                                
                                                                        }                
                                                                }
                                                                
                                                        ?>
                                                </fieldset><br>
                                </div>
                                <div class="card-action">
                                <button class="btn waves-effect waves-light" type="submit" name="flag" value='3'>Add New Face<i class="material-icons left">add</i>
                                </button>
                                </form>
                                </div>
                        </div>
                </div>
        </div>
    </div>

</body>
</html>
