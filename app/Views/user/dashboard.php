<?php

use Core\Session;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Welcome to the User Dashboard</h1>
    <p><?= Session::get("user_id"); ?></p>
    <p><?= Session::get("user_name"); ?></p>
    <p><?= Session::get("user_email"); ?></p>
    <p><?= Session::get("user_role"); ?></p>

</body>
</html>