<?php
session_start(); // Start the session
require_once 'database_connecting.php'; // We include the connection to the database

if(!empty($_POST['email']) && !empty($_POST['password'])) // If the email and password fields exist and are not empty
{
    // Patch XSS
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $email = strtolower($email); // email transformed into lower case

    // We see if the user is registered in the users table
    $check = $pdo->prepare('SELECT pseudo, email, password, token FROM registerUser WHERE email = ?');
    $check->execute(array($email));
    $data = $check->fetch();
    $row = $check->rowCount();

    // If > 0 then the user exists
    if($row > 0)
    {
        // If the mail is good in format
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            // If the password is correct
            if(password_verify($password, $data['password']))
            {
                // We create the session and we redirect to landing.php
                $_SESSION['user'] = $data['token'];
                header('Location: landing.php');
            }else{ header('Location: index.php?login_err=password');
            }
        }else{ header('Location: index.php?login_err=email');
        }
    }else{ header('Location: index.php?login_err=already');
    }
}else{ header('Location: index.php');
}
die(); // if the form is sent without any data

