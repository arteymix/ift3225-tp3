<?php

require __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (\TP3\User::register($_POST['username'], $_POST['email'], $_POST['password'])) {
        header('HTTP/1.1 302 Temporary');
        header('Location: '.\TP3\URL::rebase('/login.php'));
        exit;
    }
}
?><!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <?php require __dir__.'/../templates/head.php'; ?>
</head>
</body>
<form method="post">
    <h1>Inscription</h1>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user === NULL) :?>
        <p>Échec de l'inscription</p>
    <?php endif; ?>

    <p>
        <input name="username" placeholder="Nom d'usager">
    </p>
    <p>
        <input name="email" placeholder="Courriel">
    </p>
    <p>
        <input name="password" type="password" placeholder="Mot de passe">
    </p>
    <input type="submit">
</form>
</body>
</html>
