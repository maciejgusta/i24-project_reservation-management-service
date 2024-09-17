<?php        
$server_name="localhost";
        $username="admin";
        $password="admin";
        $dbname="jadzia";
        echo "ok";
        $conn = new mysqli($server_name, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("connection failed: ".$conn->connect_error);
        }
        echo "<p<Connection OK</p>";
                
	/*
	echo "<table>\n";
        $idx = 1;	
        while ($idx <= $table->num_rows){
            echo "<tr>\n";
            $row = $table->fetch_assoc();
            //print_r($row);
            foreach ($row as $x => $y){
                echo "<td>$y</td>\n";
            }
            $idx++;   
            echo "</tr>\n";
        }
        echo "</table>\n";
	 */
?>
