
<?php
session_start();
require_once '../database_connecting.php'; // add database connection
require_once '../header.php';
require_once '../auth.php';



// Retrieve the user's data from the current session
$req = $pdo->prepare('SELECT * FROM registerUser WHERE token = ?');
$req->execute(array($_SESSION['user']));
$data = $req->fetch();


// if the button submit is pressed, execute all actions in it
if (isset($_POST['submit'])) {


    $country = ucfirst(mb_strtolower(trim($_POST['country'])));
    // Performing read query execution
    $statementexistornot = $pdo->prepare("SELECT * from countries WHERE name = :country_name");
    $statementexistornot->execute([
        'country_name' => $country
    ]);
    $exitant_country = $statementexistornot->fetchAll();

    if ($exitant_country) {
        $countryId = $exitant_country[0]["id_countries"];
    } else {
        // Performing update query execution
        $sql = $pdo->prepare("UPDATE countries 
                SET name = :country_name
                WHERE id_countries = :id_countries");
        $sql->execute([
            'name' => $country,
        ]);
        $countryId = $pdo->lastInsertId('country');
    }

    // Performing update query execution
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

    // Performing update query execution
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

// Performing read query execution
$requete = $pdo->prepare("SELECT *
            FROM users
            join users_has_adresse uha on users.id_users = uha.users_id_users
            join adresse a on a.id_adresse = uha.adresse_id_adresse
            join countries c on a.countries_id_countries = c.id_countries
	        WHERE id_users = :id_users");

$requete->execute(['id_users' => $_GET['id']]);


//display data:
$result = $requete->fetch();


// condition to know the user id of the current session corresponds to the id of the user who created this fake user
if ($data['id'] === $result['id_registerUser']) {

?>

<!-- form html -->
<html lang="">
<head>
    <title>modification de données en PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="php" href="data_list.php">
    <link rel="stylesheet" href="../CSS/file_form.css">
    <link rel="stylesheet" href="../CSS/file_modify_delete.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>

<body>
<h2 class="h2-title">User information</h2>

    <form class="col g-3" action="modify_user.php?id=<?php echo $_GET['id'] ?>" method="post">

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

        <div class="col-12">
            <button type="submit" name="submit" class="btn btn-primary">Modify</button>
        </div>

    </form>

</body>

</html>

<?php } else {

    echo "<link rel='stylesheet' href='../CSS/file_modify_delete.css'>";
    echo "<p class='remainder'>You cannot modify the data of another user. Please modify your own data !</p>";

} ?>


































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
