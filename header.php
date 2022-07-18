<?php
require_once 'auth.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Header</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>
<body>

<!-- nav -->
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="../Users_CRUD/form.php">Users form</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="../Events_CRUD/form_event.php">Events form</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="../Users_CRUD/data_list.php">Users list</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="../Events_CRUD/event_list.php">Events list</a>
            </li>
        </ul>
    </div>

    <!-- dropdown -->
    <div class="collapse navbar-collapse" id="navbar-list-4">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/fox.jpg" width="40" height="40" class="rounded-circle">
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="../profile.php">Profile</a>
                    <a class="dropdown-item" href="../logout.php">Log Out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
</body>
