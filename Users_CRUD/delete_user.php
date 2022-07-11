

<html lang="">
<head>
    <title>supprimer des données en PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="php" href="data_list.php">
    <link rel="stylesheet" href="../CSS/file_userForm.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>


<?php
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
            FROM users
            join users_has_adresse uha on users.id_users = uha.users_id_users
            join adresse a on a.id_adresse = uha.adresse_id_adresse
            join countries c on a.countries_id_countries = c.id_countries
	        WHERE id_users = :id_users");
//exécution de la requête:
$requete->execute(['id_users' => $_GET['id']]);


//affichage des données:
$result = $requete->fetch();

?>

<?php

if (isset($_POST['delete'])) {


    $sql = $pdo->prepare("DELETE 
                FROM users_has_adresse 
                WHERE users_id_users = :users_id_users AND adresse_id_adresse = :adresse_id_adresse");
    $sql->execute(['users_id_users' => $_GET['id'],
        'adresse_id_adresse'=> $result["id_adresse"]]);



    $sql = $pdo->prepare("DELETE 
            FROM adresse 
            WHERE id_adresse = :id_adresse");
    $sql->execute([
        'id_adresse' => $result["id_adresse"]]);



    $sql = $pdo->prepare("DELETE 
                    FROM users 
                    WHERE id_users = :id_user ");
    $sql->execute([
        'id_user' => $_GET['id']
    ]);

    header('Location: data_list.php');

}



if ($data['id'] === $result['id_registerUser']) {?>


<div>

    <p>voulez vous vraiment supprimer vos données ?</p>


    <form action="delete_user.php?id=<?php echo $_GET['id'] ?>" method="post">

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

