<?php
    session_start();
    $username = (isset($_SESSION['username']) ? $_SESSION['username'] : "none");
?>

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

        $servername = "localhost";
        $dbusername = "admin";
        $password = "admin";
        $dbname = "jadzia";
        $db = new mysqli($servername, $dbusername, $password, $dbname);
        $user_id = $db->query("select * from users where username=\"$username\";")->fetch_assoc()["id_user"];
        $visits = $db->query("select * from visits where id_user=$user_id;");
        if ($visits->num_rows > 0){
            while ($visit = $visits->fetch_assoc()){
                print_r($visit);
            }
        }
    ?>
</body>
</html>