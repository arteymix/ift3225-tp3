<ul style="display: inline-block;">
    <a href="<?php echo \TP3\URL::rebase('/'); ?>">Accueil</a>
    <?php if (\TP3\User::current()): ?>
        <a href="<?php echo \TP3\URL::rebase('/user.php/' . \TP3\User::current()->username) ?>"><?php echo \TP3\User::current()->username; ?></a>
        <?php if (\TP3\User::current()->admin): ?>
            <a href="<?php echo \TP3\URL::rebase('/admin.php') ?>">Administration</a>
        <?php endif; ?>
        <a href="<?php echo \TP3\URL::rebase('/logout.php'); ?>">Déconnection</a>
    <?php else: ?>
        <a href="<?php echo \TP3\URL::rebase('/login.php'); ?>">Authentification</a>
        <a href="<?php echo \TP3\URL::rebase('/register.php'); ?>">Inscription</a>
    <?php endif; ?>
</ul>
