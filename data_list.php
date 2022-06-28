<?php
//
//require 'database_connecting.php';
//
//$sql = $pdo->prepare("SELECT * FROM users_has_adresse (users_id_users, adresse_id_adresse)
//        JOIN users U ON users_has_adresse.users_id_users = U.id_users");
//        echo "{$row['first_name']} - {$row['last_name']} - {$row['birth_date']} - {$row['email']} - {$row['phone']} - {$row['civility']} - {$row['sex']}  - {$row['street']} - {$row['postal_code']} - {$row['city']} - {$row['name']} <br>";


if (!isset($_SESSION['user'])) {
    header('Location:index.php');
    die();
}

require_once 'auth.php';
require 'database_connecting.php';
require_once 'header.php';?>

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
    $stmt = $pdo->prepare('SELECT * FROM users_has_adresse
                                 JOIN adresse A on users_has_adresse.adresse_id_adresse = A.id_adresse
                                 JOIN countries C on A.countries_id_countries = C.id_countries
                                 JOIN users U on users_has_adresse.users_id_users = U.id_users');
    $stmt->execute();
    ?>
    <?php while ($row = $stmt->fetch()) {

        ?>

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
                    <p class="title is-4"><?php echo "{$row['first_name']} {$row['last_name']}" ?></p>
                    <p class="subtitle is-6"><?php echo "{$row['email']}" ?></p>
                    <p><a href="details_user.php?id=<?php echo $row['id_users'] ?>">More details</a></p>
                    <p><a href="modify_user.php?id=<?php echo $row['id_users'] ?>">Edit</a></p>
                    <p><a href="delete_user.php?id=<?php echo $row['id_users'] ?>">Delete</a></p>
                </div>
            </div>

        </div>
        </div>

    <?php } ?>













</div>
</body>
</html>

<!---->
<!---->


<!---->
<!--/*-->
<!--if (file_exists("data.json")) {-->
<!--    $currentData = file_get_contents("data.json");-->
<!--    $arrayData = json_decode($currentData, true);-->
<!--    $arrayData[] = $myDatas;-->
<!--    $finalDataArray = json_encode($arrayData);-->
<!--    file_put_contents("data.json", $finalDataArray);-->
<!--} else {-->
<!--    fopen("data.json", "a+");-->
<!--}-->
<!--*/-->
<!---->
<!---->
<!---->
<!--/*-->
<!---->
<!--$file = fopen("data.json", "a+");-->
<!--fwrite ($file, json_encode($myDatas));-->
<!--echo $json = json_encode($myDatas);-->
<!---->
<!--*/-->

