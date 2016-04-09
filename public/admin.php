<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();

if ($user = \TP3\User::current()) {
    if (!$user->admin) {
        header('HTTP/1.1 302 Temporary');
        header('Location: '.\TP3\URL::rebase('/'));
        exit;
    }
} else {
    header('HTTP/1.1 302 Temporary');
    header('Location: '.\TP3\URL::rebase('/login.php'));
    exit;
}

?><!DOCTYPE html>
<html>
<head>
    <title>Administration</title>
</head>
<body>
<?php require __DIR__.'/../templates/navigation.php'; ?>
<h1>Administration</h1>
<table>
    <tr>
        <th style="text-align: left;">#</th>
        <th style="text-align: left;">Nom d'usager</th>
        <th style="text-align: left;">Courriel</th>
        <th style="text-align: left;">Rôle</th>
    </tr>
    <?php foreach (\TP3\User::all() as $user) : ?>
        <tr>
            <td style="text-align: left;"><?php echo $user->id ?></td>
            <td style="text-align: left;"><?php echo $user->username ?></td>
            <td style="text-align: left;"><?php echo $user->email ?></td>
            <td style="text-align: left;"><?php echo $user->admin ? 'Administrateur' : 'Usager' ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
