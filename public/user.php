<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();

$user = \TP3\User::find_by_username(substr($_SERVER['PATH_INFO'], 1));

if (!$user) {
    require __DIR__ . '/../templates/error/404.php';
    exit;
}

if (\TP3\User::current() && \TP3\User::current()->admin) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        \TP3\Database::instance()
            ->prepare('delete from users where id = :id')
            ->execute($_POST);
        header('HTTP/1.1 302 Temporary');
        header('Location: '.\TP3\URL::rebase('/admin.php'));
    }
}

?><!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($user->username) ?></title>
    <?php require __DIR__ . '/../templates/head.php'; ?>
</head>
<body>
<div class="centered container">
    <?php require __DIR__ . '/../templates/navigation.php' ?>
    <div class="row">
        <?php if (\TP3\User::current() && \TP3\User::current()->id === $user->id): ?>
            <h1>Ma page</h1>
        <?php else: ?>
            <h1>Page de l'usager <?php echo htmlspecialchars($user->username) ?></h1>
        <?php endif; ?>
        <h2>Contributions</h2>
        <ul>
            <?php foreach ($user->wikis() as $wiki): ?>
                <li>
                    <a href="<?php echo \TP3\URL::rebase('/index.php/' . rawurlencode($wiki->title)); ?>"><?php echo htmlspecialchars($wiki->title); ?></a>
                    <?php echo $wiki->parent_id ? 'Modifié' : 'Créé' ?>
                    le <?php echo $wiki->created ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if (\TP3\User::current() && \TP3\User::current()->admin): ?>
            <form method="post">
                <input type="hidden" name="id" value="<?php echo $user->id ?>">
                <button>Exterminer</button>
            </form>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
