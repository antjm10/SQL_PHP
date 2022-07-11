
<html lang="">
<head>
    <title>modification de données en PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="php" href="event_list.php">
    <link rel="stylesheet" href="../CSS/file_userForm.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>


<?php
session_start();
//connection au serveur:
require_once '../database_connecting.php';
require_once '../header.php';


//sélection de la base de données:

//requête SQL:

//exécution de la requête:

?>




<?php

// On récupere les données de l'utilisateur
$req = $pdo->prepare('SELECT * FROM registerUser WHERE token = ?');
$req->execute(array($_SESSION['user']));
$data = $req->fetch();



    if (isset($_POST['submit'])) {

// On récupere les données de l'utilisateur
        $req = $pdo->prepare('SELECT * FROM registerUser WHERE token = ?');
        $req->execute(array($_SESSION['user']));
        $data = $req->fetch();


        $sql = $pdo->prepare("UPDATE events
                        SET name = :name,
                        description = :description,
                        start_time = :start_time,
                        end_time = :end_time
                        WHERE id_events = :id_events AND id_registerUser = :id_registerUser");


        $sql->execute([
            'name' => $_POST['event_name'],
            'description' => $_POST['event_description'],
            'start_time' => $_POST['event_start_time'],
            'end_time' => $_POST['event_end_time'],
            'id_events' => $_GET['id'],
            'id_registerUser' => $data['id']
        ]);

        header('Location: event_list.php');

    }



$requete = $pdo->prepare("SELECT *
            FROM events
	        WHERE id_events = :id_events");

$requete->execute(['id_events' => $_GET['id']]);


//affichage des données:
$result = $requete->fetch();




if ($data['id'] === $result['id_registerUser']) {

?>
    <body>
<form action="modify_event.php?id=<?php echo $_GET['id'] ?>" method="post">

    <h2 class=""></h2>

    <div class="column is-4 is-offset-one-third">
        <label for="last_name">
            <input class="input" type="text" name="event_name" placeholder="name"
                   value="<?php echo $result['name'] ?>"><br>
        </label>

        <label for="first_name">
            <input class="input" type="text" name="event_description" placeholder="entrez votre prenom"
                   value="<?php echo $result['description'] ?>"><br>
        </label>

        <label>
            <input class="input" type="date" name="event_start_time" placeholder="date de naissance"
                   value="<?php echo $result['start_time'] ?>"><br>
        </label>

        <label>
            <input class="input" type="date" name="event_end_time" placeholder="addresse email"
                   value="<?php echo $result['end_time'] ?>"><br>
        </label>

        <a href="../index.php">
            <button type="submit" name="submit" class="JSP button is is-link">soumettre</button>
        </a>

    </div>


</form>

</body>
</html>

<?php } else {

    echo "You need to delete your own record";
}
?>




































<?php


/*







 session_start();
include('bd/connexionDB.php');

if (!isset($_SESSION['id'])) {
     header('Location: index.php');
exit;
}

 // On récupère les informations de l'utilisateur connecté
 $afficher_profil = $DB->query("SELECT *
 FROM utilisateur
 WHERE id = ?",
     array($_SESSION['id']));
 $afficher_profil = $afficher_profil->fetch();

 if (!empty($_POST)) {
     extract($_POST);
 $valid = true;

 if (isset($_POST['modification'])) {
         $nom = htmlentities(trim($nom));
 $prenom = htmlentities(trim($prenom));
 $mail = htmlentities(strtolower(trim($mail)));

 if (empty($nom)) {
             $valid = false;
 $er_nom = "Il faut mettre un nom";
}

 if (empty($prenom)) {
             $valid = false;
 $er_prenom = "Il faut mettre un prénom";
}

 if (empty($mail)) {
             $valid = false;
 $er_mail = "Il faut mettre un mail";

 } elseif (!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $mail)) {
             $valid = false;
 $er_mail = "Le mail n'est pas valide";

 } else {
             $req_mail = $DB->query("SELECT mail
 FROM utilisateur
 WHERE mail = ?",
                 array($mail));
 $req_mail = $req_mail->fetch();

if ($req_mail['mail'] <> "" && $_SESSION['mail'] != $req_mail['mail']) {
                 $valid = false;
 $er_mail = "Ce mail existe déjà";
 }
 }

 if ($valid) {

 $DB->insert("UPDATE utilisateur SET prenom = ?, nom = ?, mail = ?
 WHERE id = ?",
 array($prenom, $nom, $mail, $_SESSION['id']));

 $_SESSION['nom'] = $nom;
 $_SESSION['prenom'] = $prenom;
 $_SESSION['mail'] = $mail;

 header('Location:  profil.php');
 exit;

 }
 }

*/
?>
