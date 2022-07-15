<?php

session_start();
require_once '../database_connecting.php'; // ajout connexion bdd
require_once '../header.php';
require_once '../auth.php';



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
    <link rel="stylesheet" href="../CSS/file_list.css">
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
                            <img src="data:image/png;base64,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" alt="Placeholder image">
                        </figure>
                    </div>
                    <div class="media-content">
                        <p class="title is-4"><span>Event name: </span><?php echo "{$row['name']}" ?></p>
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
