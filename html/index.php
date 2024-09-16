<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <table>
    <?php
        $server_name="localhost";
        $username="admin";
        $password="admin";
        $dbname="new_schema";

        $conn = new mysqli($server_name, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("connection failed: ".$conn->connect_error);
        }
        
        $sql = "SELECT * FROM new_table";
        $table = $conn->query($sql);

        print_r($table);
/*
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
?>
*/
    </table>

</body>
</html>
