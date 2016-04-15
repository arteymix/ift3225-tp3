<?php

require __DIR__ . '/../vendor/autoload.php';

$wikis = \TP3\Wiki::all_by_terms($_GET['q']);

?><!DOCTYPE html>
<html>
<head>
    <title>Résultats de la recherche</title>
    <?php require __DIR__ . '/../templates/head.php'; ?>
</head>
<body>
<div class="centered container">
    <?php require __DIR__ . '/../templates/navigation.php'; ?>
    <div class="row">
        <h1>Résultats de la recherche</h1>
        <?php if (empty($wikis)): ?>
            <p class="missing message">Aucun résultats</p>
        <?php else: ?>
            <ul>
                <?php foreach ($wikis as $wiki): ?>
                    <li>
                        <a href="<?php echo \TP3\URL::rebase('/index.php/' . rawurlencode($wiki->title ? $wiki->title : 'Accueil')) ?>">
                            <?php echo htmlspecialchars($wiki->title) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
</body>
</html>