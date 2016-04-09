<ul style="display: inline-block;">
    <a href="<?php echo \TP3\URL::rebase('/') ?>">WikiLeaks</a>
    <?php if (\TP3\User::current()): ?>
    <a href="<?php echo \TP3\URL::rebase('/user.php/'.\TP3\User::current()->username) ?>"><?php echo \TP3\User::current()->username ?></a>
    <a href="<?php echo \TP3\URL::rebase('/logout.php') ?>">Déconnection</a>
    <?php else: ?>
    <a href="<?php echo \TP3\URL::rebase('/login.php') ?>">Authentification</a>
    <?php endif; ?>
</ul>
