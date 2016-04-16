<?php
header('HTTP/1.1 404 Not Found');
?><!DOCTYPE html>
<html>
<head>
    <title>Vous n'avez pas les permissions nécessaires</title>
    <?php require __DIR__ . '/../head.php'; ?>
</head>
<body>
<div class="centered container">
    <?php require __DIR__ . '/../navigation.php'; ?>
    <div class="row">
        <h1>Vous n'avez pas les permissions nécessaires</h1>
        <p style="display: none">Sale plèbe!</p>
    </div>
</div>
</body>
</html>
