<?php
session_start();
require_once '../database_connecting.php'; // add database connection
require_once '../header.php';
require_once '../auth.php';


// Retrieve the user's data from the current session
$req = $pdo->prepare('SELECT * FROM registerUser WHERE token = ?');
$req->execute(array($_SESSION['user']));
$data = $req->fetch();

// query SELECT
$requete = $pdo->prepare("SELECT *
            FROM users
            join users_has_adresse uha on users.id_users = uha.users_id_users
            join adresse a on a.id_adresse = uha.adresse_id_adresse
            join countries c on a.countries_id_countries = c.id_countries
	        WHERE id_users = :id_users");
// execution of the request
$requete->execute(['id_users' => $_GET['id']]);

// display data
$result = $requete->fetch();

// if the button submit is pressed, execute all actions in it
if (isset($_POST['delete'])) {

    // Performing delete query execution
    $sql = $pdo->prepare("DELETE 
                FROM users_has_adresse 
                WHERE users_id_users = :users_id_users AND adresse_id_adresse = :adresse_id_adresse");
    $sql->execute(['users_id_users' => $_GET['id'],
        'adresse_id_adresse'=> $result["id_adresse"]]);

    // Performing delete query execution
    $sql = $pdo->prepare("DELETE 
            FROM adresse 
            WHERE id_adresse = :id_adresse");
    $sql->execute([
        'id_adresse' => $result["id_adresse"]]);

    // Performing delete query execution
    $sql = $pdo->prepare("DELETE 
                    FROM users 
                    WHERE id_users = :id_users ");
    $sql->execute([
        'id_users' => $_GET['id']
    ]);

    // after all the delete, redirects to the page data_list.php
    header('Location: data_list.php');

}

// condition to know the user id of the current session corresponds to the id of the user who created this fake user
if ($data['id'] === $result['id_registerUser']) {?>

<!-- form html -->
<html lang="">
<head>
    <title>supprimer des données en PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="php" href="data_list.php">
    <link rel="stylesheet" href="../CSS/file_form.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<div>

    <h2 class="h2-title">User information</h2>

    <form action="delete_user.php?id=<?php echo $_GET['id'] ?>" method="post">

        <div class="col-md-3">
            <label for="last_name" class="form-label">Last_name:</label>
            <input type="text" name="last_name" class="form-control" id="inputLast_name" placeholder="last name" value="<?php echo $result['last_name'] ?>"><br>
        </div>

        <div class="col-md-3">
            <label for="first_name" class="form-label">First_name:</label>
            <input type="text" name="first_name" class="form-control" id="inputFirst_name" placeholder="first name" value="<?php echo $result['first_name'] ?>"><br>
        </div>

        <div class="col-md-3">
            <label for="inputPassword4" class="form-label">Birth_date:</label>
            <input type="date" name="birth_date" class="form-control" id="inputBirth_date" placeholder="birth date" value="<?php echo $result['birth_date'] ?>"><br>
        </div>

        <div class="col-md-3">
            <label for="inputEmail4" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="email" value="<?php echo $result['email'] ?>"><br>
        </div>

        <div class="col-md-3">
            <label for="inputAddress" class="form-label">Phone:</label>
            <input type="text" name="phone" class="form-control" id="inputAddress" placeholder="phone" value="<?php echo $result['phone'] ?>"><br>
        </div>

        <div class="col-md-3">
            <label for="inputAddress2" class="form-label">Civility:</label>
            <input type="text" name="civility" class="form-control" id="inputAddress2" placeholder="civility" value="<?php echo $result['civility'] ?>"><br>
        </div>

        <div class="col-md-3">
            <label for="inputCity" class="form-label">Sex:</label>
            <input type="text" name="sex" class="form-control" id="inputCity" placeholder="sex" value="<?php echo $result['sex'] ?>"><br>
        </div>

        <h2 class="h2-title">User address</h2>

        <div class="col-md-3">
            <label for="inputCity" class="form-label">Street:</label>
            <input type="text" name="street" class="form-control" id="inputCity" placeholder="street" value="<?php echo $result['street'] ?>"><br>
        </div>

        <div class="col-md-3">
            <label for="inputCity" class="form-label">Postal_code:</label>
            <input type="text" name="postal_code" class="form-control" id="inputCity" placeholder="postal code" value="<?php echo $result['postal_code'] ?>"><br>
        </div>

        <div class="col-md-3">
            <label for="inputCity" class="form-label">City:</label>
            <input type="text" name="city" class="form-control" id="inputCity" placeholder="city" value="<?php echo $result['city'] ?>"><br>
        </div>

        <div class="col-md-3">
            <label for="inputCity" class="form-label">Country:</label>
            <input type="text" name="country" class="form-control" id="inputCity" placeholder="country" value="<?php echo $result['name'] ?>"><br>
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

</html>

<?php } else {

    // If the condition is not met, proceed as follows
    echo "<link rel='stylesheet' href='../CSS/file_modify_delete.css'>";
    echo "<p class='remainder'>You cannot delete the data of another user. Please delete your own data !</p>";

} ?>
