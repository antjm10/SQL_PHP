<?php


//phpinfo();

session_start();
require_once '../database_connecting.php'; // ajout connexion bdd
// si la session existe pas soit si l'on est pas connecté on redirige
if (!isset($_SESSION['user'])) {
    header('Location:../index.php');
    die();
}



require_once '../header.php';




if (isset($_POST['submit'])) {


// Events

    // On récupere les données de l'utilisateur
    $req = $pdo->prepare('SELECT * FROM registerUser WHERE token = ?');
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();

    echo $data['id'];
    var_dump('hello');

    // Tester requète non préparée
    //

    $sql = $pdo->prepare("INSERT INTO events (name, description, start_time, end_time, id_registerUser)
                VALUES (:name, :description, :start_time, :end_time, :id_registerUser)");
    $datas = [
        'name' => $_POST['event_name'],
        'description' => $_POST['event_description'],
        'start_time' => $_POST['event_start_time'],
        'end_time' => $_POST['event_end_time'],
        'id_registerUser' => $data['id']
    ];


    ?><pre><?php
    var_dump($datas);

    ?> </pre><?php

    $sql->execute($datas);
    $id_events = $pdo->lastInsertId();




}



?>










<!DOCTYPE html>
    <html lang="en">

    <head>
        <title>GFG- Store Data</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="php" href="../Users_CRUD/data_list.php">
        <link rel="stylesheet" href="../CSS/file_userForm.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    </head>

    <body>


    <form class="col g-3" action="form_event.php" method="post">
        <h2 class="h2-title">Events:</h2>
        <div class="col-md-3">
            <label class="form-label">Name:</label>
                <input class="form-control" type="text" name="event_name" placeholder="name">

        </div>
        <br>
        <div class="col-md-3">
            <label>Description:</label>
                <input class="form-control" type="text" name="event_description" placeholder="description">

        </div>
        <br>
        <div class="col-md-3">
            <label>Start_time</label>
            <input class="form-control" type="date" name="event_start_time" placeholder="date_start">
        </div>
        <br>
        <div class="col-md-3">
            <label>End_time</label>
            <input class="form-control" type="date" name="event_end_time" placeholder="date_end">
        </div>
        <br>
        <div class="col-12">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </div>



    </form>






    </body>



</html>