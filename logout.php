<?php
session_start();
unset($_SESSION['connect']);
header('location: index.php');