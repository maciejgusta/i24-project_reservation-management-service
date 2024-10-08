<?php
    session_start();

    if (!(isset($_SESSION['username']) && isset($_SESSION['id_user']))) {
        session_unset();
        header("Location: index.php");
        exit();
    } 

    $username = (isset($_SESSION['username']) ? $_SESSION['username'] : "none");
    $id_user = (isset($_SESSION['id_user']) ? $_SESSION['id_user'] : "none");

    $current_date = new DateTime();

    $servername = "localhost";
    $dbusername = "admin";
    $password = "admin";
    $dbname = "jadzia";
    $db = new mysqli($servername, $dbusername, $password, $dbname);

    $upcoming = $db->query('select * from visits join services on visits.id_service=services.id_service where id_user="'.$id_user.'" and ((visit_date=CURDATE() and (visit_time + interval service_duration hour_second)>=(CURTIME() + interval "02:00:00" hour_second)) or (visit_date>CURDATE())) order by visit_date, visit_time;');
    $past = $db->query('select * from visits join services on visits.id_service=services.id_service where id_user="'.$id_user.'" and ((visit_date=CURDATE() and (visit_time + interval service_duration hour_second)<(CURTIME() + interval "02:00:00" hour_second)) or (visit_date<CURDATE())) order by visit_date desc, visit_time desc;');

    function add_times($x, $y){
        $s = (int)substr($x, 6, 2) + (int)substr($y, 6, 2);
        $m = (int)substr($x, 3, 2) + (int)substr($y, 3, 2) + (int)($s/60);
        $s %= 60;
        $h = (int)substr($x, 0, 2) + (int)substr($y, 0, 2) + (int)($m/60);
        $m %= 60;
        return substr('00'.$h, -2).':'.substr('00'.$m, -2).':'.substr('00'.$s, -2);
    }

    function next_meeting($visits, $action = true, $border=true){
        if ($visits->num_rows>0 && $visit = $visits->fetch_assoc()){
            $cancel_url = 'cancel_meeting.php?id_visit='. $visit['id_visit'];
            return '<div class="meeting_cell"'.($border ? '': ' style="border: none"').'"><div class="meeting_layout"></div><div class="meeting_info">'.$visit['service_name'].' | '.$visit['service_price'].'$ | '.substr($visit['visit_date'], 8, 2).'-'.substr($visit['visit_date'], 5, 2).'-'.substr($visit['visit_date'], 0, 4).' | '.$visit['visit_time'].' - '.add_times($visit['visit_time'], $visit['service_duration']).'</div>'.($action ? '<div class="meeting_layout"></div><div class="meeting_options" onclick="window.location.href=\''.$cancel_url.'\'">CANCEL</div>' : '').'<div class="meeting_layout"></div></div>';
        } else {

        }
        return '<div class="meeting_cell"'.($border ? '': ' style="border: none"').'><div class="meeting_layout"></div><div class="meeting_info"></div>'.($action ? '<div class="meeting_layout"></div><div class="meeting_options" style="font-size: 2.5vmin" onclick="window.location.href=\'schedule_meeting.php\'">SCHEDULE</div>' : '').'<div class="meeting_layout"></div></div>';

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
    <title>Meetings</title>
    <link rel="stylesheet" href="css/meetings.css">
    <script>
        window.onload = function() {
            <?php
                if (isset($_SESSION['alert'])){
                    echo 'alert("'.$_SESSION['alert'].'");';
                }
                unset($_SESSION['alert']);
            ?>
        }
    </script>
</head>
<body>
    <div class="main_block">

        <div class="header_block">My meetings</div>

        <div class="meetings_block">

            <div class="subheader_block">Upcoming meetings</div>
            
            <?php echo next_meeting($upcoming, true, false) ?>

            <?php echo next_meeting($upcoming) ?>

            <?php echo next_meeting($upcoming) ?>

            <?php echo next_meeting($upcoming) ?>

            <?php echo next_meeting($upcoming) ?>

            <div class="subheader_block">Past meetings</div>

            <?php echo next_meeting($past, false, false) ?>

            <?php echo next_meeting($past, false) ?>

            <?php echo next_meeting($past, false) ?>

            <?php echo next_meeting($past, false) ?>

            <?php echo next_meeting($past, false) ?>

        </div>

        <div class="return_to_home_page_block" onclick="window.location.href='home.php'">Return to Home</div>

    </div>
</body>
</html>