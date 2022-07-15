
<?php
    session_start();
    require_once 'database_connecting.php'; // add database connection
    require_once 'header.php';
    require_once 'auth.php';

    // Retrieve the user's data from the current session
    $req = $pdo->prepare('SELECT * FROM registerUser WHERE token = ?');
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();

?>
<!doctype html>
<html lang="en">
  <head>
    <title>Page d'atterrissage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  </head>
  <body>
        <div class="container">
            <div class="col-md-12">
                <div class="text-center">
                    <h1 class="p-5">Bonjour <?php echo $data['pseudo']; ?> !</h1>
                        <p>You can view the different pages by using the navbar. You will be able to create a fake user and see it displayed on a page that lists all the fake users that the different users registered on the site have created as for the events. If you want to log out on other pages, go to the profile image on the navbar and press log out</p>
                    <hr />
                    <a href="logout.php" class="btn btn-danger btn-lg">Disconnect</a>
                </div>
            </div>
        </div>
  </body>
</html>
