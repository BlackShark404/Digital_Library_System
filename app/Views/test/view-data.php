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
    <h1>Data collected form the form submission</h1>

    <p>Name: <?= Session::get('name') ?> </p>
    <p>Age: <?= Session::get('age') ?> </p>

</body>
</html>