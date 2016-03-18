<?php require __DIR__.'/../vendor/autoload.php'; ?>
<?php use \TP3; ?>
<?php $wiki = \TP3\Wiki::load() ?>
<!DOCTYPE html>
<html>
  <head>
  <title><?php $wiki->title ?></title>
  </head>
  <body>
  <div class="container">
    <h1><?php echo htmlspecialchars($wiki->title) ?></h1>
    <div class="row">
	  <?php echo \Markdown::transform($wiki->document) ?>
    </div>
  </div>
  </body>
</html>

