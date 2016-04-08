<ul style="display: inline-block;">
    <a href="/">WikiLeaks</a>
    <?php if (\TP3\User::current()): ?>
        <a href="/user.php/<?php echo \TP3\User::current()->username ?>"><?php echo \TP3\User::current()->username ?></a>
        <a href="/logout.php">Déconnection</a>
    <?php else: ?>
        <a href="/login.php">Authentification</a>
    <?php endif; ?>
</ul>