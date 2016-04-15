<?php

require __DIR__ . '/../vendor/autoload.php';

use \Respect\Validation\Validator as v;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $validator = v::key('username', v::notEmpty())
	    ->key('password', v::notEmpty());

    $messages = array();

    try 
    {
        $validator->check($_POST);

        if ($user = \TP3\User::authenticate($_POST['username'], $_POST['password'])) 
        {
            $_SESSION['user_id'] = $user->id;
            header('HTTP/1.1 302 Temporary');
            header('Location: '.\TP3\URL::rebase('/user.php/'.$user->username));
            exit;
        }
    } 
    catch (Exception $err)
    {
        $messages = array_merge($messages, array($err->getMainMessage()));
    }
}
?><!DOCTYPE html>
<html>
<head>
    <title>Authentification</title>
    <?php require __dir__.'/../templates/head.php'; ?>
</head>
</body>
<div class="centered container">
    <?php require __DIR__.'/../templates/navigation.php'; ?>
    <div class="row">
        <h1>Authentification</h1>
        <form method="post">
        
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user === NULL) :?>
                <p>Échec de l'authentification</p>
                <ul>
                    <?php foreach ($messages as $message): ?>
                        <li><?php echo $message ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        
            <p>
                <input name="username" placeholder="Nom d'usager">
            </p>
            <p>
                <input name="password" type="password" placeholder="Mot de passe">
            </p>
            <input type="submit">
        </form>
    </div>
</div>
</body>
</html>
