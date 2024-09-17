<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div id="login-container">
        <form action="login.php" method="post">
            <label for="username">Login:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="text" id="password" name="password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
