<?php

session_start();
require_once 'database_connecting.php'; // add database connection
require_once 'header.php';
require_once 'auth.php';



// Retrieve the user's data from the current session
$req = $pdo->prepare('SELECT * FROM registerUser WHERE token = ?');
$req->execute(array($_SESSION['user']));
$data = $req->fetch();

?>

<!-- form html -->
<html lang="">
<head>
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="CSS/file_profile.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>

<body class="body-profile">

<div class="profile">
    <img src="https://simg.nicepng.com/png/small/128-1280406_view-user-icon-png-user-circle-icon-png.png">
    <p><span>Your profile</span></p>
    <p class="subtitle is-6">Username: <?php echo $data['pseudo']?></p>
    <p class="subtitle is-6">Email: <?php echo $data['email']?></p>
</div>

</body>