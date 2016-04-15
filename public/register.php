<?php

require __DIR__ . '/../vendor/autoload.php';

use \Respect\Validation\Validator as v;
use \Respect\Validation\Exceptions\ValidationException;
use \Respect\Validation\Exceptions\NestedValidationException;

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $validator = v::key('username', v::notEmpty())
	    ->key('email', v::email())
	    ->key('password', v::notEmpty());

    $messages = array();

    try
    {
    	$validator->check($_POST);

        if (\TP3\User::register($_POST['username'], $_POST['email'], $_POST['password'])) 
        {
            header('HTTP/1.1 302 Temporary');
            header('Location: '.\TP3\URL::rebase('/login.php'));
            exit;
        } 
	else
	{
	    $messages = array_merge($messages, array('"'.$_post['username'].'" est déjà utilisé'));
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
    <title>Inscription</title>
    <?php require __DIR__.'/../templates/head.php'; ?>
</head>
</body>
<div class="centered container">
<?php require __DIR__.'/../templates/navigation.php'; ?>
<div class="row">
<form method="post">
    <h1>Inscription</h1>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user === NULL) :?>
        <ul>
            <?php foreach ($messages as $message): ?>
                <li><span class="error"><?php echo $message ?></span></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p>
	    <input name="username" value="<?php echo array_key_exists('username', $_POST) ? $_POST['username'] : '' ?>" placeholder="Nom d'usager">
    </p>
    <p>
        <input type="email" name="email" value="<?php echo array_key_exists('email', $_POST) ? $_POST['email'] : '' ?>" placeholder="Courriel">
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
