<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();

if (!\TP3\User::current() && array_key_exists('edit', $_GET))
{
	header('HTTP/1.1 302 Temporary');
	header('Location: '.\TP3\URL::rebase('/login.php?'.http_build_query(array('redirect_uri' => \TP3\URL::rebase('/index.php'.$_SERVER['PATH_INFO'].'?edit')))));
	exit;
}

if (\TP3\User::current() && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (array_key_exists('delete', $_POST)) {
        if (\TP3\Database::instance()
            ->prepare('delete from wikis where title = :title')
            ->execute(array('title' => $_POST['title']))
        ) {
            header('HTTP/1.1 302 Temporary');
            header('Location: ' . \TP3\URL::rebase('/'));
            exit;
        }
    } else if (\TP3\Database::instance()
        ->prepare('insert into wikis (title, parent_id, author_id, document) values (:title, :parent_id, :author_id, :document)')
        ->execute(array_merge(array('parent_id' => NULL), $_POST, array('author_id' => array_key_exists('user_id', $_SESSION) ? $_SESSION['user_id'] : NULL)))
    ) // récupérer l'usager depuis la session
    {
        header('HTTP/1.1 302 Temporary');
        header('Location: ' . \TP3\URL::rebase('/index.php/' . rawurlencode($_POST['title'])));
        exit;
    }
}

$wiki_title = array_key_exists('PATH_INFO', $_SERVER) ? substr($_SERVER['PATH_INFO'], 1) : 'Home';
$wiki = array_key_exists('version', $_GET) ? \TP3\Wiki::find_by_id($_GET['version']) : \TP3\Wiki::find_by_wiki_name($wiki_title);
if (!$wiki && !\TP3\User::current()) {
    require __DIR__ . '/../templates/error/404.php';
    exit;
}
?><!DOCTYPE html>
<html>
<head>
    <title><?php echo $wiki ? htmlspecialchars($wiki->title ? $wiki->title : 'Accueil') : 'Pas de Wiki :(' ?></title>
    <?php require __dir__ . '/../templates/head.php'; ?>
</head>
<body>
<div class="centered container">
    <?php require __DIR__ . '/../templates/navigation.php' ?>
    <?php if (!$wiki || array_key_exists('edit', $_GET)): ?>
        <div class="row">
           <h1><?php echo $wiki ? ($wiki->title ? htmlspecialchars($wiki->title) : 'Accueil') . ' <small>modifier</small>' : 'Créez un nouveau Wiki' ?></h1>
           <form method="post">
               <?php if ($wiki): ?>
                   <input type="hidden" name="parent_id" value="<?php echo $wiki->id ?>">
               <?php endif; ?>
               <p>
                   <input name="title" value="<?php echo htmlspecialchars($wiki ? $wiki->title : $wiki_title) ?>">
               </p>
               <p>
                   <textarea style="width: 100%;" rows="20" name="document"><?php echo $wiki ? htmlspecialchars($wiki->document) : '' ?></textarea>
               </p>
               <hr>
               <ul class="inline nav" style="text-align: right;">
	           <li><a href="<?php echo \TP3\URL::rebase('/index.php'.$_SERVER['PATH_INFO']) ?>">Annuler</a></li>
		   <li><button type="submit"><?php echo $wiki ? 'Modifier' : 'Créer' ?></button></li>
               </ul>
           </form>
        </div>
    <?php else: ?>
        <div class="row">
            <h1><?php echo $wiki ? htmlspecialchars($wiki->title ? $wiki->title : 'Accueil') : ':(' ?></h1>
            <hr>
            <?php echo $wiki ? \TP3\Markdown::transform($wiki->document) : ':(' ?>
            <hr>
</div>
<div class="row">
<div class="half column">
            <p>
            <small>
                Créé le <?php echo $wiki->created ?>
                <?php if ($author = \TP3\User::find_by_id($wiki->author_id)): ?>
                    par <a
                        href="<?php echo \TP3\URL::rebase('/user.php/' . rawurlencode($author->username)) ?>"><?php echo htmlspecialchars($author->username) ?></a>.
                <?php else: ?>
                    par un usager anonyme.
                <?php endif; ?>
            </small>
            </p>
            </div>
            <div class="half column">
                <ul class="inline nav" style="text-align: right;">
                    <li><a href="?edit">Modifier</a></li>
                    <?php if (\TP3\User::current()): ?>
                    <li>
                        <form method="post" style="display: inline;">
                                <input type="hidden" name="title" value="<?php echo htmlspecialchars($wiki->title); ?>">
                                <button name="delete">Détruire</button>
                        </form>
                   </li>
                   <?php endif; ?>
                </ul>
                </div>
            </div>
	    <?php if ($wiki->parent()): ?>
            <h2>Versions précédentes</h2>
            <ul>
                <?php $w = $wiki; ?>
                <?php while (($w = $w->parent())): ?>
		    <li>
		        <a href="?<?php echo http_build_query(array('version' => $w->id)); ?>">
                        <?php echo $w->parent_id ? 'modifié' : 'créé'; ?>
			</a>
                        le <?php echo $w->created; ?>
                        <?php if ($w->author_id): ?>
			    par <a href="<?php echo \TP3\URL::rebase('/user.php/'.rawurlencode($w->author()->username)) ?>"><?php echo htmlspecialchars($w->author()->username) ?></a>
                        <?php else: ?>
                            par un usager anonyme
                        <?php endif; ?>
                   </li>
                <?php endwhile; ?>
            </ul>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>

