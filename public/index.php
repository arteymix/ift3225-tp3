<?php require __DIR__.'/../vendor/autoload.php'; ?>
<?php $wiki = \TP3\Wiki::find_by_wiki_name("Index") ?>
<!DOCTYPE html>
<html>
  <head>
  <title><?php $wiki->title ?></title>
  </head>
  <body>
  <div class="container">
    <h1><?php echo htmlspecialchars($wiki->title) ?></h1>
    <div class="row">
	  <?php echo \TP3\Markdown::transform($wiki->document) ?>
    </div>
  </div>
  </body>
</html>

