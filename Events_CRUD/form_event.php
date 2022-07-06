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
        <link rel="stylesheet" href="../stylesheet.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    </head>

    <body>


    <form action="form_event.php" method="post">
        <h2>Events:</h2>
        <div>
            <label>
                <input class="" type="text" name="event_name" placeholder="name">
            </label>

            <label>
                <input class="" type="text" name="event_description" placeholder="description">
            </label>

            <label>
                <input class="" type="date" name="event_start_time" placeholder="date_start">
            </label>

            <label>
                <input class="" type="date" name="event_end_time" placeholder="date_end">
            </label>

            <button type="submit" name="submit" class="button is-link">soumettre</button>


            <input type="text" name="pseudo" placeholder="confirmé votre pseudo">


        </div>




    </form>






    </body>



</html>