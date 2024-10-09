<?php
    session_start();

    if (!(isset($_SESSION['username']) && isset($_SESSION['id_user']))) {
        session_unset();
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

    function add_times($x, $y){
        $s = (int)substr($x, 6, 2) + (int)substr($y, 6, 2);
        $m = (int)substr($x, 3, 2) + (int)substr($y, 3, 2) + (int)($s/60);
        $s %= 60;
        $h = (int)substr($x, 0, 2) + (int)substr($y, 0, 2) + (int)($m/60);
        $m %= 60;
        return substr('00'.$h, -2).':'.substr('00'.$m, -2).':'.substr('00'.$s, -2);
    }

    function gettop($value){
        return (((int)substr($value, 0, 2))+((int)substr($value, 3, 2)/60)+((int)substr($value, 6, 2)/3600)-8)*10;
    }

    function getheight($value){
        return (((int)substr($value, 0, 2))+((int)substr($value, 3, 2)/60)+((int)substr($value, 6, 2)/3600))*10;
    }

    unset($_SESSION['return']);
?>

<!DOCTYPE html>
<html lang="en" id="dark-mode">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
        
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>

<script>
    function toggleDarkMode() {
        const html = document.documentElement; // <html> element
        html.classList.toggle('dark-mode');
        // Zapisz wybór motywu do localStorage, aby zapamiętać go po odświeżeniu strony
        if (html.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    }

    // Ustaw motyw na podstawie zapisanych preferencji
    window.onload = function() {
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    }
</script>
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

            <div class="outer_week_backward" onclick="window.location.href=\'lw.php\'"> < </div>
            <div class="inner_week">'.$ws.' - '.$we.'</div>
            <div class="outer_week_forward" onclick="window.location.href=\'rw.php\'"> > </div>
        
        </div>

        <div class="date_block">

            <div class="logo_cell"><img src="logo.png" alt="LOGO" id="logo"></div>
        ';

        //date cell update

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

        //meetings update

        for ($i = 0; $i < 6; $i++){
            echo '<div class="day_block">';
            $curday = $date->format("Y-m-d");
            $sql = "select * from visits where id_user=$id_user and visit_date=\"$curday\";";
            $visits = $db->query($sql);
            $nuvisits = $db->query('select * from visits where not id_user="'.$id_user.'" and visit_date="'.$curday.'";');

            if ($visits->num_rows > 0){
                while ($visit = $visits->fetch_assoc()){
                    $service_time = ($visit['visit_time']);
                    $top = gettop($service_time);
                    $service_duration = $db->query('select service_duration from services where id_service="'.$visit["id_service"].'";')->fetch_assoc()['service_duration'];
                    $height = getheight($service_duration);
                    $service = $db->query('select * from services where id_service="'.$visit["id_service"].'";')->fetch_assoc();
                    echo '<div class="event_cell" style="top: '.$top.'%; height: '.$height.'%;">'.$service["service_name"].' '.$service["service_price"].'$</div>';
                }
            }

            if ($nuvisits->num_rows > 0){
                while ($visit = $nuvisits->fetch_assoc()){
                    $service_time = ($visit['visit_time']);
                    $top = gettop($service_time);
                    $service_duration = $db->query('select service_duration from services where id_service="'.$visit["id_service"].'";')->fetch_assoc()['service_duration'];
                    $height = getheight($service_duration);
                    $service = $db->query('select * from services where id_service="'.$visit["id_service"].'";')->fetch_assoc();
                    echo '<div class="event_cell" style="top: '.$top.'%; height: '.$height.'%; background-color: red">Barber busy</div>';
                }   
            }

            $sql = 'select visit_time as start_time, addtime(visit_time, service_duration) as end_time from visits join services on visits.id_service=services.id_service where visit_date="'.$curday.'" order by visit_time;';
            $allv = $db->query($sql);
            $windowstart = "08:00:00";
            $windowsize = "00:30:00";
            $windowend = add_times($windowstart, $windowsize);
            while ($allv->num_rows > 0 && $curvisit = $allv->fetch_assoc()){
                while ($windowend <= $curvisit['start_time']){
                    $top = gettop($windowstart);
                    $height = getheight($windowsize);
                    $dir = 'schedule_meeting.php?date='.$curday.'&time='.substr($windowstart,0,5).'&return=home.php';
                    echo '<div class="schedule_meeting" style="top: '.$top.'%; height: '.$height.'%;" onclick="window.location.href=\''.$dir.'\'">'.$windowstart.' - '.$windowend.'</div>';
                    $windowstart = add_times($windowstart, $windowsize);
                    $windowend = add_times($windowend, $windowsize);
                }
                while ($windowstart < $curvisit['end_time']){
                    $windowstart = add_times($windowstart, $windowsize);
                    $windowend = add_times($windowend, $windowsize);
                }

            }

            while ($windowend <= "18:00:00"){
                $top = gettop($windowstart);
                $height = getheight($windowsize);
                $dir = 'schedule_meeting.php?date='.$curday.'&time='.substr($windowstart,0,5).'&return=home.php';
                echo '<div class="schedule_meeting" style="top: '.$top.'%; height: '.$height.'%;" onclick="window.location.href=\''.$dir.'\'">'.$windowstart.' - '.$windowend.'</div>';
                $windowstart = add_times($windowstart, $windowsize);
                $windowend = add_times($windowend, $windowsize);
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

            <div class="setting_cell_left" onclick="window.location.href=\'settings.php\'">Settings</div>

            <div class="setting_cell" id="my_meetings" onclick="window.location.href=\'meetings.php\'">My meetings</div>

            <div class="setting_cell_right" onclick="window.location.href=\'log_out.php\'">Log out</div>

        </div>

        </div>
        ';

    ?>
</body>
</html>