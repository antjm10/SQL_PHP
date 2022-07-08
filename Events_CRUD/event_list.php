<?php

session_start();
require_once '../database_connecting.php'; // ajout connexion bdd
require_once '../header.php';
// si la session existe pas soit si l'on est pas connecté on redirige
if(!isset($_SESSION['user'])){
    header('Location:../index.php');
    die();
}


    $stmt = $pdo->prepare('SELECT * FROM events');
    $stmt->execute()
    ?>
    <?php while ($row = $stmt->fetch()) {



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="">
    <title>Events list</title>
</head>
<body>
<div id="results">


        <div class="card">
            <div class="card-image">
            </div>
            <div class="card-content">
                <div class="media">
                    <div class="media-left">
                        <figure class="img">
                            <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
                        </figure>
                    </div>
                    <div class="media-content">
                        <p class="title is-4"><?php echo "{$row['name']}" ?></p>
                        <p><a href="../Events_CRUD/details_event.php?id=<?php echo $row['id_events'] ?>">More details</a></p>
                        <p><a href="../Events_CRUD/modify_event.php?id=<?php echo $row['id_events'] ?>">Edit</a></p>
                        <p><a href="../Events_CRUD/delete_event.php?id=<?php echo $row['id_events'] ?>">Delete</a></p>
                    </div>
                </div>

            </div>
        </div>

    <?php } ?>













</div>
</body>
</html>
