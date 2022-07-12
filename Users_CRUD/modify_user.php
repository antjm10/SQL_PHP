<html lang="">
<head>
    <title>modification de données en PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="php" href="data_list.php">
    <link rel="stylesheet" href="../CSS/file_form.css">
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


    $country = ucfirst(mb_strtolower(trim($_POST['country'])));
    $statementexistornot = $pdo->prepare("SELECT * from countries WHERE name = :country_name");
    $statementexistornot->execute([
        'country_name' => $country
    ]);
    $exitant_country = $statementexistornot->fetchAll();

    if ($exitant_country) {
        $countryId = $exitant_country[0]["id_countries"];
    } else {
        $sql = $pdo->prepare("UPDATE countries 
                SET name = :country_name
                WHERE id_countries = :id_countries");
        $sql->execute([
            'name' => $country,
        ]);
        $countryId = $pdo->lastInsertId('country');
    }


    $sql = $pdo->prepare("UPDATE adresse 
            SET street = :street,
            postal_code = :postal_code,
            city = :city
            WHERE countries_id_countries = :countries_id_countries");
    $sql->execute([
        'street' => $_POST['street'],
        'postal_code' => $_POST['postal_code'],
        'city' => $_POST['city'],
        'countries_id_countries' => $countryId]);


    $sql = $pdo->prepare("UPDATE users 
                    SET first_name = :first_name, 
                    last_name = :last_name, 
                    birth_date = :birth_date, 
                    email = :email, 
                    phone = :phone, 
                    civility = :civility, 
                    sex = :sex
                    WHERE id_users = :id_users ");
    $sql->execute([
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'birth_date' => $_POST['birth_date'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'civility' => $_POST['civility'],
        'sex' => $_POST['sex'],
        'id_users' => $_GET['id']
    ]);

    header('Location: data_list.php');

}

$requete = $pdo->prepare("SELECT *
            FROM users
            join users_has_adresse uha on users.id_users = uha.users_id_users
            join adresse a on a.id_adresse = uha.adresse_id_adresse
            join countries c on a.countries_id_countries = c.id_countries
	        WHERE id_users = :id_users");

$requete->execute(['id_users' => $_GET['id']]);


//affichage des données:
$result = $requete->fetch();



if ($data['id'] === $result['id_registerUser']) {

?>

<body>
<form action="modify_user.php?id=<?php echo $_GET['id'] ?>" method="post">

    <h2 class=""></h2>

    <div class="column is-4 is-offset-one-third">
        <label for="last_name">
            <input class="input" type="text" name="last_name" placeholder="entrez votre nom"
                   value="<?php echo $result['last_name'] ?>"><br>
        </label>

        <label for="first_name">
            <input class="input" type="text" name="first_name" placeholder="entrez votre prenom"
                   value="<?php echo $result['first_name'] ?>"><br>
        </label>

        <label>
            <input class="input" type="date" name="birth_date" placeholder="date de naissance"
                   value="<?php echo $result['birth_date'] ?>"><br>
        </label>

        <label>
            <input class="input" type="email" name="email" placeholder="addresse email"
                   value="<?php echo $result['email'] ?>"><br>
        </label>

        <label>
            <input class="input" type="text" name="phone" placeholder="numero de telephone"
                   value="<?php echo $result['phone'] ?>"><br>
        </label>

        <label>
            <input class="input" type="text" name="civility" placeholder="entrez votre civilité"
                   value="<?php echo $result['civility'] ?>"><br>
        </label>

        <label>
            <input class="input" type="text" name="sex" placeholder="entrer votre genre"
                   value="<?php echo $result['sex'] ?>"><br>
        </label>

        <h2 class="JSP">Adresse:</h2>

        <label>
            <input class="input" type="text" name="street" placeholder="rue"
                   value="<?= $result['street'] ?>"><br>
        </label>

        <label>
            <input class="input" type="number" name="postal_code" placeholder="postal_code"
                   value="<?php echo $result['postal_code'] ?>"><br>
        </label>

        <label>
            <input class="input" type="text" name="city" placeholder="city"
                   value="<?php echo $result['city'] ?>"><br>
        </label>

        <label>
            <input class="input" type="text" name="country" placeholder="country"
                   value="<?php echo $result['name'] ?>"><br>
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
}?>


































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
