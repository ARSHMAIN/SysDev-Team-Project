<?php
include_once 'Views/Shared/session.php';
session_unset();
session_destroy();
?>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="Views/Styles/shared.css">
    <link rel="stylesheet" type="text/css" href="Views/Styles/navbar.css">
</head>
<body>
<?php
include_once 'Views/Shared/navbar.php';
?>
<form action="/?controller=login&action=validation" method="POST">
    <label for="email">Email</label>
    <input id="email" type="text" name="email" required><br>
    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    <input type="submit" name="submit" value="Login">
</form>
</body>
</html>