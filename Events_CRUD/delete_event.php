
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
            FROM events
	        WHERE id_events = :id_events");
$requete->execute(['id_events' => $_GET['id']]);


// display data
$result = $requete->fetch();

// if the button submit is pressed, execute all actions in it
if (isset($_POST['delete'])) {

    // Performing delete query execution
    $sql = $pdo->prepare("DELETE 
                    FROM events 
                    WHERE id_events = :id_events ");
    $sql->execute([
        'id_events' => $_GET['id']
    ]);

    // after all the delete, redirects to the page data_list.php
    header('Location: event_list.php');

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

    // If the condition is not met, proceed as follows
    echo "<link rel='stylesheet' href='../CSS/file_modify_delete.css'>";
    echo "<p class='remainder'>You cannot delete the data of another user. Please delete your own data !</p>";

} ?>
