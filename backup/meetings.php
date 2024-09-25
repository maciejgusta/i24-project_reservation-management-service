<?php
    session_start();
    $username = (isset($_SESSION['username']) ? $_SESSION['username'] : "none");
    $id_user = (isset($_SESSION['id_user']) ? $_SESSION['id_user'] : "none");
    $current_date = new DateTime();
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

            <div class="status_meetings_block">

                <div class="subheader_block">Past meetings</div>
                
                <div class="meeting_cell">

                    <div class="meeting_info">test meeting</div>
                    <div class="meeting_options">cancel</div>

                </div>

            </div>
            <div class="status_meetings_block">

                <div class="subheader_block">Upcoming meetings</div>

            </div>

        </div>

    </div>
</body>
</html>