<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();

if ($user = \TP3\User::current()) {
    if (!$user->admin) {
        require __DIR__ . '/../templates/error/403.php';
        exit;
    }
} else {
    header('HTTP/1.1 302 Temporary');
    header('Location: ' . \TP3\URL::rebase('/login.php').'?'.http_build_query(array('redirect_uri' => \TP3\URL::rebase('/admin.php'))));
    exit;
}

?><!DOCTYPE html>
<html>
<head>
    <title>Administration</title>
    <?php require __dir__ . '/../templates/head.php'; ?>
</head>
<body>
<div class="centered container">
<?php require __DIR__ . '/../templates/navigation.php'; ?>
<div class="row">
<h1>Administration</h1>
</div>
<div class="row">
<div class="half column">
    <h2>Liste des usagers</h2>
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
                <td style="text-align: left;">
                <a href="<?php echo \TP3\URL::rebase('/user.php/'.rawurlencode($user->username)); ?>"><?php echo htmlspecialchars($user->username); ?></a>
    
                </td>
                <td style="text-align: left;"><?php echo $user->email ?></td>
                <td style="text-align: left;"><?php echo $user->admin ? 'Administrateur' : 'Usager' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<div class="half column">
    <h2>Liste des wikis</h2>
    <table>
        <tr>
            <th style="text-align: left;">#</th>
            <th style="text-align: left;">Titre</th>
            <th style="text-align: left;">Date de création</th>
            <th style="text-align: left;">Auteur</th>
        </tr>
        <?php foreach (\TP3\Wiki::all() as $wiki) : ?>
            <tr>
                <td style="text-align: left;"><?php echo $wiki->id ?></td>
		<td style="text-align: left;"><a href="<?php echo \TP3\URL::rebase('/index.php/'.rawurlencode($wiki->title)) ?>"><?php echo htmlspecialchars($wiki->title) ?></a></td>
                <td style="text-align: left;"><?php echo $wiki->created ?></td>
                <td style="text-align: left;"><?php echo $wiki->author_id ? $wiki->author()->username : 'Anonyme' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</div>
</div>
</body>
</html>
