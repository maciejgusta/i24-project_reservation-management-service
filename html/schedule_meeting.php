<?php
    session_start();

    if (!(isset($_SESSION['username']) && isset($_SESSION['id_user']))) {
        session_unset();
        header("Location: index.php");
        exit();
    } 

    $db_servername = "localhost";
    $db_username = "admin";
    $db_password = "admin";
    $db_name = "jadzia";
    
    $db = new mysqli($db_servername, $db_username, $db_password, $db_name);

    $services = $db->query('select * from services');

    $default_date = isset($_GET['date']) ? $_GET['date'] : false;
    unset($_GET['date']);
    $default_time = isset($_GET['time']) ? $_GET['time'] : false;
    unset($_GET['time']);
    $_SESSION['return'] = isset($_GET['return']) ? $_GET['return'] : (isset($_SESSION['return']) ? $_SESSION['return'] : "meetings.php");
    unset($_GET['return']);
?>  

<!DOCTYPE html>
<html id="dark-mode" lang="en">
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
    <title>Schedule a meeting</title>
    <link rel="stylesheet" href="css/schedule_meeting.css">
</head>
<body>
    <div id="back" onclick="window.location.href='<?php echo $_SESSION['return']; ?>'">Return</div>
    <div id="title">Schedule a meeting</div>
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
            <input class="input" type="date" name="date" <?php if ($default_date) echo 'value="'.$default_date.'"' ?> required>

            <label class="label" for="time">Time:</label>
            <input class="input" type="time" name="time" <?php if ($default_time) echo 'value="'.$default_time.'"' ?>required>
                   
            <div id="information_block">
            <?php
                if (isset($_SESSION['error'])){
                    echo '<div id="information_div">'.$_SESSION['error'].'</div>';
                    unset($_SESSION['error']);
                }
                if (isset($_SESSION['meeting'])){
                    echo '<div id="information_div" style="background-color: #32CD32;">Meeting scheduled successfully!</div>';
                    unset($_SESSION['meeting']);
                }
                
            ?>
            </div>

            <button id="schedule_button" type="submit" name="schedule">Schedule</button>
        </form>

    </div>
</body>
</html>
