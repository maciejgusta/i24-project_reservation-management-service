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
    <link rel="stylesheet" href="css/schedule.css">
</head>
<body>
    <?php
        $date = new DateTime();
        $day = (int)$date->format("w");
        $chg = $day == 0 ? "+1 days" : "-".($day-1)." days";
        $date->modify($chg);

        $ws = $date->format("d-m-Y");
        $we = $date->modify("+5 days")->format("d-m-Y");

        $date->modify("-5 days");

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
        echo '
        <div class="calendar_block">

        <div class="date_block">

            <div class="logo_cell"></div>
        ';

        for ($i = 0; $i < 6; $i++){
            $cur_date = $date->format("d-m-Y");
            $cur_wk = $date->format("D");
            echo '<div class="date_cell">'.$cur_date.' ('.$cur_wk.')</div>';
            $date->modify("+1 days");
        }

        echo '
        </div>

        <div class="time_block">

            <div class="hour_block">
                <div class="hour_cell">8:00</div>
                <div class="hour_cell">9:00</div>
                <div class="hour_cell">10:00</div>
                <div class="hour_cell">11:00</div>
                <div class="hour_cell">12:00</div>
                <div class="hour_cell">13:00</div>
                <div class="hour_cell">14:00</div>
                <div class="hour_cell">15:00</div>
                <div class="hour_cell">16:00</div>
                <div class="hour_cell">17:00</div>
            </div>

            <div class="day_block"></div>
            <div class="day_block"></div>
            <div class="day_block"></div>
            <div class="day_block"></div>
            <div class="day_block"></div>
            <div class="day_block"></div>

            <div class="line" id="l10"></div>
            <div class="line" id="l20"></div>
            <div class="line" id="l30"></div>
            <div class="line" id="l40"></div>
            <div class="line" id="l50"></div>
            <div class="line" id="l60"></div>
            <div class="line" id="l70"></div>
            <div class="line" id="l80"></div>
            <div class="line" id="l90"></div>

        </div>
    
        </div>
        ';

    ?>
</body>
</html>