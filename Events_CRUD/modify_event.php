
<?php
session_start();
//connection au serveur:
require_once '../database_connecting.php';  // add database connection
require_once '../header.php';
require_once '../auth.php';



//sélection de la base de données:

//requête SQL:

//exécution de la requête:

// Retrieve the user's data from the current session
$req = $pdo->prepare('SELECT * FROM registerUser WHERE token = ?');
$req->execute(array($_SESSION['user']));
$data = $req->fetch();


// if the button submit is pressed, execute all actions in it

if (isset($_POST['submit'])) {

        // On récupere les données de l'utilisateur
        $req = $pdo->prepare('SELECT * FROM registerUser WHERE token = ?');
        $req->execute(array($_SESSION['user']));
        $data = $req->fetch();

        // Performing update query execution
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

    // after all the modify, redirects to the page data_list.php
    header('Location: event_list.php');

}

// Performing read query execution
$requete = $pdo->prepare("SELECT *
            FROM events
	        WHERE id_events = :id_events");

$requete->execute(['id_events' => $_GET['id']]);

//display data:
$result = $requete->fetch();



// condition to know the user id of the current session corresponds to the id of the user who created this fake user
if ($data['id'] === $result['id_registerUser']) {
?>

<html lang="">
<head>
    <title>modification de données en PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="php" href="event_list.php">
    <link rel="stylesheet" href="../CSS/file_form.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <form action="modify_event.php?id=<?php echo $_GET['id'] ?>" method="post">

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

        <div>

            <a href="../index.php">
                <button type="submit" name="submit" class="JSP btn btn-primary">Modify</button>
            </a>

        </div>




    </form>

</body>
</html>

<?php } else {

    echo "<link rel='stylesheet' href='../CSS/file_modify_delete.css'>";
    echo "<p class='remainder'>You cannot modify the data of another user. Please modify your own data !</p>";

} ?>

