<div class="row">
<div class="half column">
    <ul class="inline nav">
        <li><a href="<?php echo \TP3\URL::rebase('/'); ?>">Accueil</a></li>
        <?php if (\TP3\User::current()): ?>
            <li><a href="<?php echo \TP3\URL::rebase('/user.php/' . \TP3\User::current()->username) ?>"><?php echo \TP3\User::current()->username; ?></a></li>
            <?php if (\TP3\User::current()->admin): ?>
                <li><a href="<?php echo \TP3\URL::rebase('/admin.php') ?>">Administration</a></li>
            <?php endif; ?>
            <li><a href="<?php echo \TP3\URL::rebase('/logout.php'); ?>">Déconnexion</a></li>
        <?php else: ?>
            <li><a href="<?php echo \TP3\URL::rebase('/login.php'); ?>">Authentification</a></li>
            <li><a href="<?php echo \TP3\URL::rebase('/register.php'); ?>">Inscription</a></li>
        <?php endif; ?>
    </ul>
</div>
<div class="half column" style="text-align: right;">
    <form action="<?php echo \TP3\URL::rebase('/search.php'); ?>">
    <input type="search" name="q" value="<?php echo array_key_exists('q', $_GET) ? htmlspecialchars($_GET['q']) : ''; ?>">
	<button type="submit">Rechercher</button>
    </form>
</div>
</div>
