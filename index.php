<?php
    session_start();
    require_once __DIR__ . '/conn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IAMS - Laptop/Desktop</title>

    <!-- IAMS ICON -->
    <link rel = "icon" href = "../img/sidebar_logo.png" type = "image/x-icon">

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="./asset/pms_style.css" />

    <!-- CSS BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- BOOTSTRAP ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- INCLUDE CREATE PMS FORM -->
    <?php require_once __DIR__ . '/components/pms_form.php' ?>
    <?php require_once __DIR__ . '/components/pms_history.php' ?>
    
    <!-- SWEET ALERT SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>

    <!-- BOOTSTRAP SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- AJAX CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- PMS SCRIPT JS -->
    <script src="./asset/pms_script.js"></script>
</body>

</html>