<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule</title>
</head>
<body>
    <?php
        $date = new DateTime();
        $day = (int)$date->format("w");
        $chg = "-".(6-$day)." days";
        //echo "$date   $chg";
        $date->modify($chg);

        $ws = $date->format("d-m-Y");
        $we = $date->modify("+6 days")->format("d-m-Y");
        echo "<h1 style=\"text-align: center\">".$ws." - ".$we."</h1>";

        // $servername = "localhost";
        // $username = "admin";
        // $password = "admin";
        // $dbname = "jadzia";

        // $db = new mysqli($servername, $username, $password, $dbname);
        
        // $sql = "select * from visits";
        // $result = $db->query($sql);
        // print_r($result);
    ?>
</body>
</html>