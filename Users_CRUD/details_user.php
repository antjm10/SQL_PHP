<?php
session_start();
require '../database_connecting.php'; // add database connection
require_once '../header.php';
require_once '../auth.php';

// Query SELECT
$stmt = $pdo->prepare('SELECT * FROM users_has_adresse                                 JOIN adresse A on users_has_adresse.adresse_id_adresse = A.id_adresse
                         INNER JOIN countries C on A.countries_id_countries = C.id_countries
                         INNER JOIN users U on users_has_adresse.users_id_users = U.id_users
                         INNER JOIN registerUser rU on U.id_registerUser = rU.id
                         WHERE id_users = :id_users');

$stmt->execute([
    'id_users' => $_GET['id']
]);

//display data with the variable row:
$row = $stmt->fetch();

// Query SELECT
$stmt = $pdo->prepare('SELECT * FROM users                              
                         WHERE id_users = :id_users');

$stmt->execute([
    'id_users' => $_GET['id']
]);
//display data table user with the variable user:
$user = $stmt->fetch();
?>

<!-- display details data html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="../CSS/file_details.css">
    <title>Users list</title>
</head>
<body>
<div id="results">
<h2>Details:</h2>
    <div class="box">
        <div class="card-image">
        </div>
        <div class="card-content">
            <div class="media">
                <div class="media-left">
                </div>
                <div class="media-content">
                    <p class="subtitle is-6"><span>Full name: </span><?php echo $row['first_name'] . " " . $row['last_name'] ?></p>
                    <p class="subtitle is-6"><span>Email: </span><?php echo $user['email']?></p>
                    <p class="subtitle is-6"><span>Birth date: </span><?php echo $row['birth_date']?></p>
                    <p class="subtitle is-6"><span>Phone: </span><?php echo $row['phone']?></p>
                    <p class="subtitle is-6"><span>Civility: </span> <?php echo $row['civility']?></p>
                    <p class="subtitle is-6"><span>Sex: </span><?php echo $row['sex']?></p>
                    <p class="subtitle is-6"><span>Street: </span> <?php echo $row['street']?></p>
                    <p class="subtitle is-6"><span>Postal code: </span><?php echo $row['postal_code']?></p>
                    <p class="subtitle is-6"><span>City: </span><?php echo $row['city'] ?></p>
                    <!-- display country name -->
                    <p class="subtitle is-6"><span>Country:</span> <?php echo $row['name'] ?></p>
                    <!-- displays the user's username for the current session -->
                    <p class="subtitle is-6"><span>Created by</span> <?php echo $row['pseudo'] ?></p>
                </div>
            </div>
        </div>
    </div>


