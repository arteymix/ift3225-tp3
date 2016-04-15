<?php

require __DIR__ . '/../vendor/autoload.php';

use \Respect\Validation\Validator as v;
use \Respect\Validation\Exceptions\ValidationException;
use \Respect\Validation\Exceptions\NestedValidationException;

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
            header('Location: '.(array_key_exists('redirect_uri', $_GET) ? $_GET['redirect_uri'] : \TP3\URL::rebase('/user.php/'.$user->username)));
            exit;
        }
	else
	{
	    $messages = array_merge($messages, array('l\'authentification a échouée'));
	}
    } 
    catch (NestedValidationException $err)
    {
        $messages = array_merge($messages, $err->getMessages());
    }
    catch (ValidationException $err)
    {
        $messages = array_merge($messages, array($err->getMainMessage()));
    }
}
?><!DOCTYPE html>
<html>
<head>
    <title>Authentification</title>
    <?php require __DIR__.'/../templates/head.php'; ?>
</head>
</body>
<div class="centered container">
    <?php require __DIR__.'/../templates/navigation.php'; ?>
    <div class="row">
        <h1>Authentification</h1>
        <form method="post">
        
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user === NULL) :?>
                <ul class="error">
                    <?php foreach ($messages as $message): ?>
                        <li><span class="error"><?php echo htmlspecialchars($message) ?></span></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        
            <p>
		    <input name="username" value="<?php echo array_key_exists('username',  $_POST) ? htmlspecialchars($_POST['username']) : ''; ?>" placeholder="Nom d'usager">
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
