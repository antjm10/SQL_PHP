<?php
session_start();
require_once '../database_connecting.php'; // add database connection
require_once '../header.php';
require_once '../auth.php';


// if the button submit is pressed, execute all actions in it
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
        // Performing insert query execution
        $sql = $pdo->prepare("INSERT INTO countries (name)
                VALUES (:name)");
        $sql->execute([
            'name' => $country,
        ]);
        $countryId = $pdo->lastInsertId('country');
    }

    // Retrieve the user's data from the current session
    $req = $pdo->prepare('SELECT * FROM registerUser WHERE token = ?');
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();

    require_once '../header.php';

    // Performing insert query execution
    $sql = $pdo->prepare("INSERT INTO adresse (street, postal_code, city, countries_id_countries)
                VALUES (:street, :postal_code, :city, :countries_id_countries)");
    $sql->execute(['street' => $_POST['street'],
        'postal_code' => $_POST['postal_code'],
        'city' => $_POST['city'],
        'countries_id_countries' => $countryId]);
    $id_adresse = $pdo->lastInsertId();

    // Performing insert query execution
    $sql = $pdo->prepare("INSERT INTO users (first_name, last_name, birth_date, email, phone, civility, sex, id_registerUser) 
                VALUES (:first_name, :last_name, :birth_date, :email, :phone, :civility, :sex, :id_registerUser)");
    $sql->execute(['first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'birth_date' => $_POST['birth_date'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'civility' => $_POST['civility'],
        'sex' => $_POST['sex'],
        'id_registerUser' => $data['id']]);
    $id_user = $pdo->lastInsertId();

    // Performing insert query execution
    $sql = $pdo->prepare("INSERT INTO users_has_adresse (users_id_users, adresse_id_adresse)
                VALUES (:users_id_users, :adresse_id_adresse)");
    $sql->execute(['users_id_users' => $id_user,
        'adresse_id_adresse' => $id_adresse]);

    // after all the insertions, redirects to the page data_list.php
    header('location: data_list.php');

}
?>

<!-- form html -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>GFG- Store Data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="php" href="data_list.php">
    <link rel="stylesheet" href="../CSS/file_form.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body class="body">

    <h2 class="h2-title">User information </h2>

        <form class="col g-3 form" action="form.php" method="post">
            <div class="col-md-3">
                <label for="last_name" class="form-label">Last_name:</label>
                <input type="text" name="last_name" class="form-control" id="inputLast_name" placeholder="last name">
            </div>
            <br>
            <div class="col-md-3">
                <label for="first_name" class="form-label">First_name:</label>
                <input type="text" name="first_name" class="form-control" id="inputFirst_name" placeholder="first name">
            </div>
            <br>
            <div class="col-md-3">
                <label for="inputPassword4" class="form-label">Birth_date:</label>
                <input type="date" name="birth_date" class="form-control" id="inputBirth_date" placeholder="birth date">
            </div>
            <br>
            <div class="col-md-3">
                <label for="inputEmail4" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" id="inputEmail" placeholder="email">
            </div>
            <br>
            <div class="col-md-3">
                <label for="inputAddress" class="form-label">Phone:</label>
                <input type="text" name="phone" class="form-control" id="inputAddress" placeholder="phone">
            </div>
            <br>
            <div class="col-md-3">
                <label for="inputAddress2" class="form-label">Civility:</label>
                <input type="text" name="civility" class="form-control" id="inputAddress2" placeholder="civility">
            </div>
            <br>
            <div class="col-md-3">
                <label for="inputCity" class="form-label">Sex:</label>
                <input type="text" name="sex" class="form-control" id="inputCity" placeholder="sex">
            </div>

            <h2 class="h2-title">User address</h2>

            <div class="col-md-3">
                <label for="inputCity" class="form-label">Street:</label>
                <input type="text" name="street" class="form-control" id="inputCity" placeholder="street">
            </div>
            <br>
            <div class="col-md-3">
                <label for="inputCity" class="form-label">Postal_code:</label>
                <input type="text" name="postal_code" class="form-control" id="inputCity" placeholder="postal code">
            </div>
            <br>
            <div class="col-md-3">
                <label for="inputCity" class="form-label">City:</label>
                <input type="text" name="city" class="form-control" id="inputCity" placeholder="city">
            </div>
            <br>
            <div class="col-md-3">
                <label for="inputCity" class="form-label">Country:</label>
                <input type="text" name="country" class="form-control" id="inputCity" placeholder="country">
            </div>
            <br>
            <div class="col-12">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

</body>

</html>










