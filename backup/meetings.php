<?php
    session_start();
    $username = (isset($_SESSION['username']) ? $_SESSION['username'] : "none");
    $id_user = (isset($_SESSION['id_user']) ? $_SESSION['id_user'] : "none");
    $current_date = new DateTime();

    $servername = "localhost";
    $dbusername = "admin";
    $password = "admin";
    $dbname = "jadzia";
    $db = new mysqli($servername, $dbusername, $password, $dbname);

    $upcoming = $db->query('select * from visits join services on visits.id_service=services.id_service where id_user="'.$id_user.'" and ((visit_date=CURDATE() and (visit_time + interval service_duration hour_second)>=(CURTIME() + interval "02:00:00" hour_second)) or (visit_date>CURDATE()));');
    $past = $db->query('select * from visits join services on visits.id_service=services.id_service where id_user="'.$id_user.'" and ((visit_date=CURDATE() and (visit_time + interval service_duration hour_second)>=(CURTIME() + interval "02:00:00" hour_second)) or (visit_date>CURDATE()));');
    print_r($upcoming);
    print_r($past);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meetings</title>
    <link rel="stylesheet" href="css/meetings.css">
</head>
<body>
    <div class="main_block">

        <div class="header_block">My meetings</div>

        <div class="meetings_block">

            <div class="subheader_block">Upcoming meetings</div>
            
            <div class="meeting_cell">
                <div class="meeting_info">
                    <?php
                    // echo "test";
                    //     if ($upcoming->current_field() $upcoming->num_rows()){

                    //     }

                    ?>
                </div>
                <div class="meeting_options"></div>
            </div>
            <div class="meeting_cell"></div>
            <div class="meeting_cell"></div>
            <div class="meeting_cell"></div>
            <div class="meeting_cell"></div>

            <div class="subheader_block">Past meetings</div>

            <div class="meeting_cell">
                <div class="meeting_info"></div>
            </div>
            <div class="meeting_cell"></div>
            <div class="meeting_cell"></div>
            <div class="meeting_cell"></div>
            <div class="meeting_cell"></div>

        </div>

    </div>
</body>
</html>