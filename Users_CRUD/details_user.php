<?php

require '../database_connecting.php';
require_once '../header.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="data.css">
    <title>Users list</title>
</head>
<body>
<div id="results">
    <?php


        $stmt = $pdo->prepare('SELECT * FROM users_has_adresse                                 JOIN adresse A on users_has_adresse.adresse_id_adresse = A.id_adresse
                                 INNER JOIN countries C on A.countries_id_countries = C.id_countries
                                 INNER JOIN users U on users_has_adresse.users_id_users = U.id_users
                                 INNER JOIN registerUser rU on U.id_registerUser = rU.id
                                 WHERE id_users = :id_users');

    $stmt->execute([
            'id_users' => $_GET['id']
        ]);
    $row = $stmt->fetch();




    ?>


    <div class="box">
            <div class="card-image">
            </div>
            <div class="card-content">
                <div class="media">
                    <div class="media-left">
                    </div>
                    <div class="media-content">
                        <p class="title is-4"><?php echo $row['first_name'] . " " . $row['last_name'] ?></p>
                        <p class="subtitle is-6"><?php echo $row['email']?></p>
                        <p class="subtitle is-6"><?php echo $row['birth_date']?></p>
                        <p class="subtitle is-6"><?php echo $row['phone']?></p>
                        <p class="subtitle is-6"><?php echo $row['civility']?></p>
                        <p class="subtitle is-6"><?php echo $row['sex']?></p>
                        <p class="subtitle is-6"><?php echo $row['street']?></p>
                        <p class="subtitle is-6"><?php echo $row['postal_code']?></p>
                        <p class="subtitle is-6"><?php echo $row['city'] ?></p>
                        <!-- display country name -->
                        <p class="subtitle is-6"><?php echo $row['name'] ?></p>
                        <p class="subtitle is-6">Crée par <?php echo $row['pseudo'] ?></p>

                    </div>
                </div>
            </div>
    </div>


