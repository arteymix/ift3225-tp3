<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($user = \TP3\User::authenticate($_POST['username'], $_POST['password'])) {
        $_SESSION['user_id'] = $user->id;
        header('HTTP/1.1 302 Temporary');
        header('Location: '.\TP3\URL::rebase('/user.php/'.$user->username));
        exit;
    }
}
?><!DOCTYPE html>
<html>
<head>
    <title>Authentification</title>
    <?php require __dir__.'/../templates/head.php'; ?>
</head>
</body>
<?php require __DIR__.'/../templates/navigation.php'; ?>
<h1>Authentification</h1>
<form method="post">

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user === NULL) :?>
        <p>Échec de l'authentification</p>
    <?php endif; ?>

    <p>
        <input name="username" placeholder="Nom d'usager">
    </p>
    <p>
        <input name="password" type="password" placeholder="Mot de passe">
    </p>
    <input type="submit">
</form>
</body>
</html>
