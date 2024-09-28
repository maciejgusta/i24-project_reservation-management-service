<?php
    session_start();

    if (!(isset($_SESSION['username']) && isset($_SESSION['id_user']))) {
        header("Location: index.php");
        exit();
    } 

    $username = (isset($_SESSION['username']) ? $_SESSION['username'] : "none");
    $id_user = (isset($_SESSION['id_user']) ? $_SESSION['id_user'] : "none");
    if (isset($_SESSION['date'])){
        $date = $_SESSION['date'];
    } else {
        $date = new DateTime();
        $day = (int)$date->format("w");
        $chg = $day == 0 ? "+1 days" : "-".($day-1)." days";
        $date->modify($chg);
        $_SESSION['date'] = $date;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <?php
        $ws = $date->format("d-m-Y");
        $we = $date->modify("+5 days")->format("d-m-Y");

        $date->modify("-5 days");

        $servername = "localhost";
        $dbusername = "admin";
        $password = "admin";
        $dbname = "jadzia";
        $db = new mysqli($servername, $dbusername, $password, $dbname);

        echo '

        <div class="calendar_block">

        <div class="week_block">

            <div class="outer_week" onclick="window.location.href=\'lw.php\'"> < </div>
            <div class="inner_week">'.$ws.' - '.$we.'</div>
            <div class="outer_week" onclick="window.location.href=\'rw.php\'"> > </div>
        
        </div>

        <div class="date_block">

            <div class="logo_cell"><img src="logo.png" alt="LOGO" id="logo"></div>
        ';

        for ($i = 0; $i < 6; $i++){
            $cur_date = $date->format("d-m-Y");
            $cur_wk = $date->format("l");
            echo '<div class="date_cell">'.$cur_date.'<br>('.$cur_wk.')</div>';
            $date->modify("+1 days");
        }
        $date->modify("-6 days");

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
        ';
        for ($i = 0; $i < 6; $i++){
            echo '<div class="day_block">';
            $curday = $date->format("Y-m-d");
            $sql = "select * from visits where id_user=$id_user and visit_date=\"$curday\"";
            $result = $db->query($sql);
            $nuvisits = $db->query('select * from visits where not id_user="'.$id_user.'" and visit_date="'.$curday.'";');

            if ($result->num_rows > 0){
                while ($visit = $result->fetch_assoc()){
                    $service_time = ($visit['visit_time']);
                    $top = (((int)substr($service_time, 0, 2))+((int)substr($service_time, 3, 2)/60)+((int)substr($service_time, 6, 2)/3600)-8)*10;
                    $service_duration = $db->query('select service_duration from services where id_service="'.$visit["id_service"].'";')->fetch_assoc()['service_duration'];
                    $height = (((int)substr($service_duration, 0, 2))+((int)substr($service_duration, 3, 2)/60)+((int)substr($service_duration, 6, 2)/3600))*10;
                    $service = $db->query('select * from services where id_service="'.$visit["id_service"].'";')->fetch_assoc();
                    echo '<div class="event_cell" style="top: '.$top.'%; height: '.$height.'%;">'.$service["service_name"].' '.$service["service_price"].'$</div>';
                }
            }

            if ($nuvisits->num_rows > 0){
                while ($visit = $nuvisits->fetch_assoc()){
                    $service_time = ($visit['visit_time']);
                    $top = (((int)substr($service_time, 0, 2))+((int)substr($service_time, 3, 2)/60)+((int)substr($service_time, 6, 2)/3600)-8)*10;
                    $service_duration = $db->query('select service_duration from services where id_service="'.$visit["id_service"].'";')->fetch_assoc()['service_duration'];
                    $height = (((int)substr($service_duration, 0, 2))+((int)substr($service_duration, 3, 2)/60)+((int)substr($service_duration, 6, 2)/3600))*10;
                    $service = $db->query('select * from services where id_service="'.$visit["id_service"].'";')->fetch_assoc();
                    //echo '<div class="event_cell" style="top: '.$top.'%; height: '.$height.'%; background-color: red">'.$service["service_name"].' '.$service["service_price"].'$</div>';
                    echo '<div class="event_cell" style="top: '.$top.'%; height: '.$height.'%; background-color: red">Barber busy</div>';
                }   
            }
            echo '</div>';

            $date->modify("+1 days");

        }
        $date->modify("-6 days");        
        echo '

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

        <div class="settings_block">

            <div class="setting_cell" onclick="window.location.href=\'settings.php\'">Settings</div>

            <div class="setting_cell" id="my_meetings" onclick="window.location.href=\'meetings.php\'">My meetings</div>

            <div class="setting_cell" onclick="window.location.href=\'log_out.php\'">Log out</div>

        </div>

        </div>
        ';

    ?>
</body>
</html>