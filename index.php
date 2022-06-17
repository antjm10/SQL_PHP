<?php

session_start();
$title = "Page d'accueil";
require_once 'auth.php';

if (isset($_POST['submit'])) {
    header('location: login.php');

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Page d'accueil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="php" href="data_list.php">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>


    <form action="login.php" method="post">

    <div class="column is-one-fifth">

        <button type="submit" class="btn btn-primary">Login</button>

    </div>

