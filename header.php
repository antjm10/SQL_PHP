<?php
require_once 'auth.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Header</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>



<nav class="navbar navbar is-dark" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="form.php">Form</a>
            <?php if (is_connect()): ?>
            <a class="navbar-item" href="data_list.php">Users list</a>
            <?php endif ?>
        </div>

        <div class="navbar-end">
                        <?php if (is_connect()): ?>
                            <a class="navbar-item" href="logout.php" >disconnect</a>
                        <?php endif ?>
        </div>
    </div>
</nav>
