<?php

if (!(isset($_SESSION['username']) && isset($_SESSION['id_user']))) {
    session_unset();
    header("Location: index.php");
    exit();
} 

    function add_times($x, $y){
        $s = (int)substr($x, 6, 2) + (int)substr($y, 6, 2);
        $m = (int)substr($x, 3, 2) + (int)substr($y, 3, 2) + (int)($s/60);
        $s %= 60;
        $h = (int)substr($x, 0, 2) + (int)substr($y, 0, 2) + (int)($m/60);
        $m %= 60;
        return substr('00'.$h, -2).':'.substr('00'.$m, -2).':'.substr('00'.$s, -2);
    }


    session_start();
    if (isset($_POST['schedule'])){
        $id_service = $_POST['service'];
        $date = $_POST['date'];
        $start = $_POST['time'].':00';
        $id_user = $_SESSION['id_user'];

        $db_servername = "localhost";
        $db_username = "admin";
        $db_password = "admin";
        $db_name = "jadzia";
    
        $db = new mysqli($db_servername, $db_username, $db_password, $db_name);
        
        $end = add_times($start, $db->query('select service_duration from services where id_service="'.$id_service.'";')->fetch_assoc()['service_duration']);

        date_default_timezone_set('Europe/Warsaw');

        $datetime = new DateTime();
        $curtime = $datetime->format("H:i:s");
        $curdate = $datetime->format("Y-m-d");

        if ($date < $curdate || ($date == $curdate && $start < $curtime)){
            $_SESSION['error'] = "You cannot schedule a meeting in the past!";
            header("Location: schedule_meeting.php");
            exit();
        }

        if ((int)substr($start, 0, 2) < 8){
            $_SESSION['error'] = "You cannot schedule a meeting before 8:00:00!";
            header("Location: schedule_meeting.php");
            exit();
        }

        if ((int)substr($end, 0, 2) >= 18 && ((int)substr($end, 3, 2) > 0 || (int)substr($end, 6,2) > 0)){
            $_SESSION['error'] = "You cannot schedule a meeting that ends after 18:00:00!";
            header("Location: schedule_meeting.php");
            exit();
        }

        $sql = 'SELECT * FROM visits 
        JOIN services ON visits.id_service = services.id_service 
        WHERE visit_date = "'.$date.'" 
        AND NOT (
            ("'.$start.'" >= ADDTIME(visit_time, service_duration)) 
            OR ("'.$end.'" <= visit_time)
        );';

        $collisions = $db->query($sql);

        if ($collisions->num_rows > 0){
            echo "collision detected";
            $_SESSION['error'] = "You cannot schedule a meeting during different meeting, check the meeting calendar for details!";
            header("Location: schedule_meeting.php");
            exit();
        }
    
        $db->query('insert into visits (id_user, id_service, visit_date, visit_time) values ("'.$id_user.'", "'.$id_service.'", "'.$date.'", "'.$start.'");');
        $_SESSION['meeting'] = true;
        header("Location: schedule_meeting.php");
        exit();
    }
?>