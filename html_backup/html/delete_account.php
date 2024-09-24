<?php
    session_start();
    $id_user = (isset($_SESSION['id_user']) ? $_SESSION['id_user'] : "none");
    $db_servername = "localhost";
    $db_username = "admin";
    $db_password = "admin";
    $db_name = "jadzia";
    $db = new mysqli($db_servername, $db_username, $db_password, $db_name);
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete my account</title>
    <link rel="stylesheet" href="css/delete_account.css">
</head>
<body>

    <div class="main_block">

    </div>  
    
</body>
</html> -->


<?php
    $db->query("delete from users where id_user=\"$id_user\";");
    if (isset($_SESSION['date'])){
        unset($_SESSION['date']);
    }
    if (isset($_SESSION['error'])){
        unset($_SESSION['error']);
    }
    header("Location: index.php");
    exit();
?>