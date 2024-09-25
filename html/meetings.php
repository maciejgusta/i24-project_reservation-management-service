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

    function next_meeting($visits){
        if ($visits->num_rows>0 && $visit = $visits->fetch_assoc()){
            return $visit['service_name'].' | '.$visit['service_price'].'$ | '.substr($visit['visit_date'], 8, 2).'-'.substr($visit['visit_date'], 5, 2).'-'.substr($visit['visit_date'], 0, 4).' | '.$visit['visit_time'].' - '.add_times($visit['visit_time'], $visit['service_duration']);
        }
        return "";
    }

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
                    <?php echo next_meeting($upcoming) ?>
                </div>

                <div class="meeting_options"></div>

            </div>

            <div class="meeting_cell">

                <div class="meeting_info">
                    <?php echo next_meeting($upcoming) ?>
                </div>

                <div class="meeting_options"></div>

            </div>

            <div class="meeting_cell">

                <div class="meeting_info">
                    <?php echo next_meeting($upcoming) ?>
                </div>

                <div class="meeting_options"></div>

            </div>

            <div class="meeting_cell">

                <div class="meeting_info">
                    <?php echo next_meeting($upcoming) ?>
                </div>

                <div class="meeting_options"></div>

            </div>

            <div class="meeting_cell">

                <div class="meeting_info">
                    <?php echo next_meeting($upcoming) ?>
                </div>

                <div class="meeting_options"></div>

            </div>

            <div class="subheader_block">Past meetings</div>

            <div class="meeting_cell">

                <div class="meeting_info">
                    <?php echo next_meeting($past) ?>
                </div>

                <div class="meeting_options"></div>

            </div>

            <div class="meeting_cell">

                <div class="meeting_info">
                    <?php echo next_meeting($past) ?>
                </div>

                <div class="meeting_options"></div>

            </div>

            <div class="meeting_cell">

                <div class="meeting_info">
                    <?php echo next_meeting($past) ?>
                </div>

                <div class="meeting_options"></div>

            </div>

            <div class="meeting_cell">

                <div class="meeting_info">
                    <?php echo next_meeting($past) ?>
                </div>

                <div class="meeting_options"></div>

            </div>

            <div class="meeting_cell">

                <div class="meeting_info">
                    <?php echo next_meeting($past) ?>
                </div>

                <div class="meeting_options"></div>

            </div>

        </div>

    </div>
</body>
</html>