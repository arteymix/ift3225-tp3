<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (\TP3\Database::instance()
        ->prepare('insert into wikis (title, parent_id, author_id, document) values (:title, :parent_id, :author_id, :document)')
        ->execute(array_merge(array('parent_id' => NULL), $_POST, array('author_id' => NULL)))
    ) // récupérer l'usager depuis la session
    {
        header('HTTP/1.1 302 Temporary');
        header('Location: '.\TP3\URL::rebase('/index.php/'.$_POST['title']));
        exit;
    }
}

$wiki_title = array_key_exists('PATH_INFO', $_SERVER) ? substr($_SERVER['PATH_INFO'], 1) : 'Home';
$wiki = \TP3\Wiki::find_by_wiki_name($wiki_title);
?><!DOCTYPE html>
<html>
<head>
    <title><?php $wiki ? htmlspecialchars($wiki->title) : 'Pas de Wiki :(' ?></title>
    <?php require __dir__.'/../templates/head.php'; ?>
</head>
<body>
<div class="container">
    <?php require __DIR__.'/../templates/navigation.php' ?>
    <?php if (!$wiki || array_key_exists('edit', $_GET)): ?>
        <h1><?php echo $wiki ? ($wiki->title ? htmlspecialchars($wiki->title) : 'Accueil') . ' <small>modifier</small>' : 'Créez un nouveau Wiki' ?></h1>
        <form method="post">
            <p>
                <input name="title" value="<?php echo htmlspecialchars($wiki ? $wiki->title : $wiki_title) ?>">
            </p>
            <p>
                <textarea style="width: 100%;" rows="20" name="document"><?php echo $wiki ? htmlspecialchars($wiki->document) : '' ?></textarea>
            </p>
            <input type="submit">
        </form>
    <?php else: ?>
        <h1><?php echo $wiki ? htmlspecialchars($wiki->title ? $wiki->title : 'WikiLeaks') : ':(' ?></h1>
        <div class="row">
            <?php echo $wiki ? \TP3\Markdown::transform($wiki->document) : ':(' ?>
            <p>
                Créé le <?php echo $wiki->created ?>
                <?php if ($author = \TP3\User::find_by_id($wiki->author_id)): ?>
                    par <?php echo $author->username ?>
                <?php else: ?>
                    par un usager anonyme
                <?php endif; ?>
            </p>
            <p><a href="?edit">Modifier</a></p>
        </div>
    <?php endif ?>
</div>
</body>
</html>

