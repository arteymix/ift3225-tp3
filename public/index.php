<?php
require __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (\TP3\Database::instance()
        ->prepare('insert into wikis (title, parent_id, author_id, document) values (:title, :parent_id, :author_id, :document)')
        ->execute(array_merge(array('parent_id' => NULL), $_POST, array('author_id' => NULL)))
    ) // récupérer l'usager depuis la session
    {
        header('HTTP/1.1 302 Temporary');
        header('Location: /index.php/' . $_POST['title']);
        exit;
    }
}

$wiki_title = array_key_exists('PATH_INFO', $_SERVER) ? substr($_SERVER['PATH_INFO'], 1) : 'Home';
$wiki = \TP3\Wiki::find_by_wiki_name($wiki_title);
?><!DOCTYPE html>
<html>
<head>
    <title><?php $wiki ? $wiki->title : 'Pas de Wiki :(' ?></title>
</head>
<body>
<div class="container">
    <?php if ($wiki): ?>
        <h1><?php echo $wiki ? htmlspecialchars($wiki->title) : ':(' ?></h1>
        <div class="row">
            <?php echo $wiki ? \TP3\Markdown::transform($wiki->document) : ':(' ?>
        </div>
    <?php else: ?>
        <h1>Créez </h1>
        <form method="post">
            <p>
                <input name="title" value="<?php echo $wiki_title ?>">
            </p>
            <p>
                <textarea name="document"></textarea>
            </p>
            <input type="submit">
        </form>
    <?php endif ?>
</div>
</body>
</html>

