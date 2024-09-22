<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule</title>
</head>
<body>
    <?php
        $date = date("Y-m-d");
        $day = date("w");
        $start_w = $date->modify(-6+(7-$day));
        echo($start_w);
    ?>
</body>
</html>