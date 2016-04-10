<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();

$user = \TP3\User::find_by_username(substr($_SERVER['PATH_INFO'], 1));

?><!DOCTYPE html>
<html>
<head>
    <title><?php echo $user->username ?></title>
    <?php require __dir__.'/../templates/head.php'; ?>
</head>
<body>
<?php require __DIR__ . '/../templates/navigation.php' ?>
<?php if (\TP3\User::current() && \TP3\User::current()->id === $user->id): ?>
    <h1>Ma page</h1>
<?php else: ?>
    <h1>Page de l'usager <?php echo $user->username ?></h1>
<?php endif; ?>
<h2>Contributions</h2>
<ul>
</ul>
</body>
</html>
