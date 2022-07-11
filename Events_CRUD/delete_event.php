<html lang="">
<head>
    <title>supprimer des données en PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="php" href="data_list.php">
    <link rel="stylesheet" href="../CSS/file_userForm.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
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

    <p>voulez vous vraiment supprimer vos données ?</p>


    <form action="delete_event.php?id=<?php echo $_GET['id'] ?>" method="post">

        <div class="column is-4 is-offset-one-third">
            <label for="last_name">
                <input class="input" type="text" name="event_name" placeholder="entrez votre nom"
                       value="<?php echo $result['name'] ?>"><br>
            </label>

            <label for="first_name">
                <input class="input" type="text" name="event_description" placeholder="entrez votre prenom"
                       value="<?php echo $result['description'] ?>"><br>
            </label>

            <label>
                <input class="input" type="text" name="event_start_time" placeholder="date de naissance"
                       value="<?php echo $result['start_time'] ?>"><br>
            </label>

            <label>
                <input class="input" type="text" name="event_end_time" placeholder=""
                       value="<?php echo $result['end_time'] ?>"><br>
            </label>

            <button type="submit" name="delete" class="JSP button is-link">Oui</button>

            <a href="../index.php">
                <button type="button" name="back" value="index.php" class="JSP button is-link">non</button>
            </a>

        </div>

    </form>
</div>

<?php } else {
    echo "You cannot remove other data user";
}?>
