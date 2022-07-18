<?php
session_start();
require '../database_connecting.php';
require_once '../header.php';
require_once '../auth.php';
?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
        <link rel="stylesheet" href="../CSS/file_details.css">
        <title>Events list</title>
    </head>
    <body>
    <div id="results">
<?php

//

$stmt = $pdo->prepare("SELECT * FROM events
                                        INNER JOIN registerUser rU on events.id_registerUser = rU.id
                                        WHERE id_events = :id_events");

$stmt->execute([
    'id_events' => $_GET['id']
]);
$row = $stmt->fetch();



?>

<h2>Details:</h2>
        <div class="box">
            <div class="card-image">
            </div>
            <div class="card-content">
                <div class="media">
                    <div class="media-left">
                    </div>
                    <div class="media-content">
                        <p class="subtitle is-6"><span>Event name: </span><?php echo $row['name']?></p>
                        <p class="subtitle is-6"><span>Description: </span><?php echo $row['description']?></p>
                        <p class="subtitle is-6"><span>Event start: </span><?php echo $row['start_time']?></p>
                        <p class="subtitle is-6"><span>Event end: </span><?php echo $row['end_time']?></p>
                        <p class="subtitle is-6"><span>Created by </span><?php echo $row['pseudo']?></p>

                    </div>
                </div>
            </div>
        </div>


