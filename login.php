<?php
$error = null;
if (!empty($_POST['user_name']) && !empty($_POST['password'])) {
    if ($_POST['user_name'] === 'Anthony' && $_POST['password'] === 'Miéville') {
        session_start();
        $_SESSION['connect'] = 1;
        header('location: form.php');
    } else {
        $error = "Identifiants incorrects";
    }
}
/*
require_once 'auth.php';
if (is_connect()) {
    header('location form.php');
    exit();
}
*/
?>

<?php if ($error): ?>
<div class="">
    <?= $error ?>
</div>
<?php endif; ?>

<form action="" method="post">

    <div class="form-groupe">
        <input class="form-control" type="text" name="user_name" placeholder="user_name">
    </div>
    <div class="form-groupe">
        <input class="form-control" type="password" name="password" placeholder="password">
    </div>
    <button type="submit" class="btn btn-primary">Connect</button>

</form>



