<?php


//phpinfo();

session_start();
require_once 'database_connecting.php'; // ajout connexion bdd
// si la session existe pas soit si l'on est pas connecté on redirige
if (!isset($_SESSION['user'])) {
    header('Location:index.php');
    die();
}

// On récupere les données de l'utilisateur
$req = $pdo->prepare('SELECT * FROM registerUser WHERE token = ?');
$req->execute(array($_SESSION['user']));
$data = $req->fetch();


require_once 'header.php';

// Performing insert query execution

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
        $sql = $pdo->prepare("INSERT INTO countries (name)
                VALUES (:name)");
        $sql->execute([
            'name' => $country,
        ]);
        $countryId = $pdo->lastInsertId('country');
    }


    $sql = $pdo->prepare("INSERT INTO adresse (street, postal_code, city, countries_id_countries)
                VALUES (:street, :postal_code, :city, :countries_id_countries)");
    $sql->execute(['street' => $_POST['street'],
        'postal_code' => $_POST['postal_code'],
        'city' => $_POST['city'],
        'countries_id_countries' => $countryId]);
    $id_adresse = $pdo->lastInsertId();


    $sql = $pdo->prepare("INSERT INTO users (first_name, last_name, birth_date, email, phone, civility, sex) 
                VALUES (:first_name, :last_name, :birth_date, :email, :phone, :civility, :sex)");
    $sql->execute(['first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'birth_date' => $_POST['birth_date'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'civility' => $_POST['civility'],
        'sex' => $_POST['sex']]);
    $id_user = $pdo->lastInsertId();


    $sql = $pdo->prepare("INSERT INTO users_has_adresse (users_id_users, adresse_id_adresse)
                VALUES (:users_id_users, :adresse_id_adresse)");
    $sql->execute(['users_id_users' => $id_user,
        'adresse_id_adresse' => $id_adresse]);



}




?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>GFG- Store Data</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="php" href="data_list.php">
        <link rel="stylesheet" href="stylesheet.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    </head>

    <body>
    <h1 class="JSP">Storing Form data in Database</h1>

    <ul>
        <li class="JSP"><a href="data_list.php">Users list</a></li>
    </ul>

    <form action="form.php" method="post">

        <h2 class="JSP">User:</h2>

        <div class="column is-4 is-offset-one-third">
            <label for="last_name">
                <input class="input" type="text" name="last_name" placeholder="entrez votre nom"><br>
            </label>

            <label for="first_name">
                <input class="input" type="text" name="first_name" placeholder="entrez votre prenom"><br>
            </label>

            <label>
                <input class="input" type="date" name="birth_date" placeholder="date de naissance"><br>
            </label>

            <label>
                <input class="input" type="email" name="email" placeholder="addresse email"><br>
            </label>

            <label>
                <input class="input" type="text" name="phone" placeholder="numero de telephone"><br>
            </label>

            <label>
                <input class="input" type="text" name="civility" placeholder="entrez votre civilité"><br>
            </label>

            <label>
                <input class="input" type="text" name="sex" placeholder="entrer votre genre"><br>
            </label>

            <h2 class="JSP">Adresse:</h2>

            <label>
                <input class="input" type="text" name="street" placeholder="rue"><br>
            </label>

            <label>
                <input class="input" type="number" name="postal_code" placeholder="postal_code"><br>
            </label>

            <label>
                <input class="input" type="text" name="city" placeholder="city"><br>
            </label>

            <label for="country">
                <input class="input" type="text" name="country" placeholder="country"><br>
            </label>


            <button type="submit" name="submit" class="JSP button is-link">soumettre</button>

        </div>


    </form>
    </body>

    </html>










