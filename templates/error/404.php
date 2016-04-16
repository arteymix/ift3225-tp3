<?php

header('HTTP/1.1 404 Not Found');
?><!DOCTYPE html>
    <html>
<head>
    <title>Page non trouvée</title>
    <?php require __DIR__.'/../head.php'; ?>
</head>
<body>
    <div class="centered container">
        <?php require __DIR__.'/../navigation.php'; ?>
        <div class="row">
            <h1>Page non trouvée</h1>
            <p>
	    Il est possible que vous deviez <a href="<?php echo \TP3\URL::rebase('/register.php'); ?>">vous enregistrer</a> 
	    ou <a href="<?php echo \TP3\URL::rebase('/login.php?'.http_build_query(array('redirect_uri' => \TP3\URL::rebase('/index.php').$_SERVER['PATH_INFO']))); ?>">vous autentifier</a> 
	    afin de pouvoir créer cette page.
        </div>
    </div>
</body>
</html>
