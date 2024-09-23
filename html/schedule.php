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
    <link rel="stylesheet" href="style.css">
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
        // if ($visits->num_rows > 0){
        //     while ($visit = $visits->fetch_assoc()){
        //         print_r($visit);
        //     }
        // }
        echo "<div class=\"calendar_block\">
        <div class=\"dotted_lines\" id=\"dl1\"></div>
        <div class=\"dotted_lines\" id=\"dl2\"></div>
        <div class=\"dotted_lines\" id=\"dl3\"></div>
        <div class=\"dotted_lines\" id=\"dl4\"></div>
        <div class=\"dotted_lines\" id=\"dl5\"></div>
        <div class=\"dotted_lines\" id=\"dl6\"></div>
        <div class=\"dotted_lines\" id=\"dl7\"></div>
        <div class=\"dotted_lines\" id=\"dl8\"></div>
        <div class=\"dotted_lines\" id=\"dl9\"></div>
        <div class=\"time_cell\">
            <div class=\"hour_cell\">9:00</div>
            <div class=\"hour_cell\">10:00</div>
            <div class=\"hour_cell\">11:00</div>
            <div class=\"hour_cell\">12:00</div>
            <div class=\"hour_cell\">13:00</div>
            <div class=\"hour_cell\">14:00</div>
            <div class=\"hour_cell\">15:00</div>
            <div class=\"hour_cell\">16:00</div>
            <div class=\"hour_cell\">17:00</div>
            <div class=\"hour_cell\">18:00</div>
        </div>
        <div class=\"day_cell\"></div>
        <div class=\"day_cell\"><div class=\"event_cell\">test</div></div>
        <div class=\"day_cell\"></div>
        <div class=\"day_cell\"></div>
        <div class=\"day_cell\"></div>
        <div class=\"day_cell\"></div>
        </div>";

    ?>
</body>
</html>