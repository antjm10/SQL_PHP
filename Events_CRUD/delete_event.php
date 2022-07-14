<html lang="">
<head>
    <title>supprimer des données en PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="php" href="data_list.php">
    <link rel="stylesheet" href="../CSS/file_form.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>


<?php
session_start();
//connection au serveur:
require_once '../database_connecting.php';
require_once '../header.php';?>


<?php

//récupération de la variable d'URL,
//qui va nous permettre de savoir quel enregistrement modifier

// On récupere les données de l'utilisateur
$req = $pdo->prepare('SELECT * FROM registerUser WHERE token = ?');
$req->execute(array($_SESSION['user']));
$data = $req->fetch();


//requête SQL:
//sélection de la base de données:
$requete = $pdo->prepare("SELECT *
            FROM events
	        WHERE id_events = :id_events");
//exécution de la requête:
$requete->execute(['id_events' => $_GET['id']]);


//affichage des données:
$result = $requete->fetch();

?>

<?php

if (isset($_POST['delete'])) {






    $sql = $pdo->prepare("DELETE 
                    FROM events 
                    WHERE id_events = :id_events ");
    $sql->execute([
        'id_events' => $_GET['id']
    ]);

    header('Location: event_list.php');

}

?>
<?php
if ($data['id'] === $result['id_registerUser']) {?>

<div>


    <form action="delete_event.php?id=<?php echo $_GET['id'] ?>" method="post">

        <h2 class="h2-title">Events:</h2>

        <div class="col-md-3">
            <label for="last_name" class="form-label">name_event:</label>
            <input type="text" name="event_name" class="form-control" id="inputLast_name" placeholder="last name" value="<?php echo $result['name'] ?>"><br>
        </div>

        <div class="col-md-3">
            <label for="first_name" class="form-label">description:</label>
            <input type="text" name="event_description" class="form-control" id="inputFirst_name" placeholder="first name" value="<?php echo $result['description'] ?>"><br>
        </div>

        <div class="col-md-3">
            <label for="inputPassword4" class="form-label">start_time:</label>
            <input type="date" name="event_start_time" class="form-control" id="inputBirth_date" placeholder="birth date" value="<?php echo $result['start_time'] ?>"><br>
        </div>

        <div class="col-md-3">
            <label for="inputEmail4" class="form-label">end_time:</label>
            <input type="date" name="event_end_time" class="form-control" id="inputEmail" placeholder="email" value="<?php echo $result['end_time'] ?>"><br>
        </div>

        <p>voulez vous vraiment supprimer vos données ?</p>

        <div class="btn-group">
            <button type="submit" name="delete" class="yes btn btn-primary">Oui</button>

            <a href="data_list.php">
                <button type="button" name="back" value="data_list.php" class="no btn btn-primary">non</button>
            </a>
        </div>

    </form>
</div>

<?php } else {
    echo "You cannot remove other data user";
}?>
