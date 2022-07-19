
<?php
require_once 'database_connecting.php'; // We include the connection to the database

// If the variables exist and they are not empty
if(isset($_POST['pseudo']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_retype']))
{
    // Patch XSS (Cross-site scripting (XSS) is a script injection attack on a web application that accepts input but improperly separates the data from the executable code before sending that input back to a user's browser)
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password_retype = htmlspecialchars($_POST['password_retype']);

    // We check if the user exists by its email to prevent a duplicate user
    $check = $pdo->prepare("SELECT pseudo, email, password FROM registerUser WHERE email = ?");
    $check->execute(array($email));
    $data = $check->fetch();
    $row = $check->rowCount();

    $email = strtolower($email); // all uppercase letters are transformed into lowercase to avoid that for example Foo@gmail.com and foo@gmail.com are two different counts

    // If the query returns a 0 then the user does not exist
    if($row == 0)
    {
        if(strlen($pseudo) <= 100) // We check that the length of the username is smaller than or equal to 100
        {
            if(strlen($email) <= 100) // We check that the length of the mail is smaller than or equal to 100
            {
                if(filter_var($email, FILTER_VALIDATE_EMAIL)) // If the email is of the right form
                {
                    if($password == $password_retype) // If the two mdp entered are good
                    {
                        // We hash the password with Bcrypt, via a cost of 12
                        $cost = ['cost' => 12];
                        $password = password_hash($password, PASSWORD_BCRYPT, $cost);

                        // We store the IP address
                        $ip = $_SERVER['REMOTE_ADDR'];

                        // We insert in the database
                        $insert = $pdo->prepare('INSERT INTO registerUser(pseudo, email, password, ip, token)VALUES(:pseudo, :email, :password, :ip, :token)');
                        $insert->execute(array(
                            'pseudo' => $pseudo,
                            'email' => $email,
                            'password' => $password,
                            'ip' => $ip,
                            'token' => bin2hex(openssl_random_pseudo_bytes(64))
                        ));
                        // We redirect with the success message
                        header('location: register.php?reg_err=success');
                        die();
                    }else header('location: register.php?reg_err=password'); die();
                }else header('location: register.php?reg_err=email'); die();
            }else header('location: register.php?reg_err=email_length'); die();
        }else header('location: register.php?reg_err=pseudo_length'); die();
    }else header('location: register.php?reg_err=already'); die();


}













