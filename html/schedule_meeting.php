<?php
    session_start();

    $db_servername = "localhost";
    $db_username = "admin";
    $db_password = "admin";
    $db_name = "jadzia";
    
    $db = new mysqli($db_servername, $db_username, $db_password, $db_name);

    $services = $db->query('select * from services');
?>  

<!DOCTYPE html>
<html id="html_form" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule a meeting</title>
    <link rel="stylesheet" href="css/schedule_meeting.css">
</head>
<body>
	<div id="schedule_block">
        <form id="schedule_form" action="schedule_meeting_backend.php" method="post">
            
            <label class="label" for="service">Service type:</label>
            <select name="service" class="input" required>
                <?php
                    while ($services->num_rows>0 && $service = $services->fetch_assoc()){
                        echo '<option value="'.$service['id_service'].'" class="input">'.$service['service_name'].' ('.$service['service_price'].'$)</option>';
                    }
                ?>
            </select>

            <label class="label" for="date">Date:</label>
            <input class="input" type="date" name="date" required>

            <label class="label" for="time">Time:</label>
            <input class="input" type="time" name="time" required>
                   
            <div id="credentials_block">
            <?php
                echo '<div id="credentials_div">PAST DATE, PAST TIME ERROR TODO</div>';
            ?>
            </div>

            <button id="schedule_button" type="submit" name="schedule">Schedule</button>
        </form>

    </div>
</body>
</html>
