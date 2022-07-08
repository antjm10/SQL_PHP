
<?php
    session_start();
    require_once 'database_connecting.php'; // add database connection
    require_once 'header.php';
   // if the session doesn't exist or if you are not connected we redirect
    if(!isset($_SESSION['user'])){
        header('Location:index.php');
        die();
    }

    // On récupere les données de l'utilisateur
    $req = $pdo->prepare('SELECT * FROM registerUser WHERE token = ?');
    $req->execute(array($_SESSION['user']));
    $data = $req->fetch();

?>
<!doctype html>
<html lang="en">
  <head>
    <title>Espace membre</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
        <div class="container">
            <div class="col-md-12">
                <div class="text-center">
                    <h1 class="p-5">Bonjour <?php echo $data['pseudo']; ?> !</h1>
                        <p>You can view the different pages by using the navbar</p>
                    <hr />
                    <a href="logout.php" class="btn btn-danger btn-lg">Disconnect</a>
                </div>
            </div>
        </div>
  </body>
</html>
