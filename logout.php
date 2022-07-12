<?php
session_start(); // start of the session
session_destroy(); // we destroy the session(s), or if you use another session, preferably use the unset()
header('Location:index.php'); // We redirect
die();