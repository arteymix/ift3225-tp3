<?php

namespace TP3;

class Markdown
{
	public function __construct (\WikiProvider $wiki_provider) {
		$this->wiki_provider = $wiki_provider;
	}

	public static function transform($input)
	{
		// en-têtes
		$input = preg_replace_callback('/^(#{1,6})\s*(.*)$/m', function($matches) {
			return '<h'.strlen($matches[1]).'>'.htmlspecialchars($matches[2]).'</h'.strlen($matches[1]).'>';
		}, $input);

		$input = preg_replace_callback('/^-\s*(.*)$/m', function($matches) {
			return '<ul><li>'.$matches[1].'</li></ul>';
		}, $input);

		$input = preg_replace('/<\/ul>\n<ul>/', '', $input);

		// substitue les **gras**
		$input = preg_replace_callback('/\*\*(.*)\*\*/', function($matches) {
			return '<strong>'.htmlspecialchars($matches[1]).'</strong>';
		}, $input);

		// substitue les *italique*
		$input = preg_replace_callback('/\*(.*)\*/', function($matches) {
			return '<em>'.htmlspecialchars($matches[1]).'</em>';
		}, $input);

		// substitue les [lien](url)
		$input = preg_replace_callback('/\[(.*)\]\((.*)\)/', function($matches) {
			var_dump($matches);
			return '<a href="'.$matches[2].'">'.$matches[1].'</a>';
		}, $input);

		// substitue les WikiLinks
		$input = preg_replace_callback('/[A-Z]\w+[A-Z]\w+/', function($matches) {
			return '<a href="/index.php/'.$matches[0].'">'.$matches[0].'</a>';
		}, $input);

		// paragraphes
		$input = preg_replace_callback('/(.+)(\n\n|\Z)/', function($matches) {
			return '<p>'.($matches[1]).'</p>';
		}, $input);

		$input = preg_replace('/\n/', '', $input);

		return $input;
	}
}

