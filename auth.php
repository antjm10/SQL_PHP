<?php
// if the session doesn't exist or if you are not connected we redirect
if(!isset($_SESSION['user'])){
    header('Location:../index.php');
    die();
}