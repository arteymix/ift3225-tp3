<?php

namespace TP3;

class Markdown
{
	public static function transform($input)
	{
		$input = htmlspecialchars($input);

		// en-têtes
		$input = preg_replace_callback('/^(#{1,6})\s*(.*)$/m', function($matches) {
			return '<h'.strlen($matches[1]).'>'.$matches[2].'</h'.strlen($matches[1]).'>';
		}, $input);

		// substitue les **gras**
		$input = preg_replace_callback('/\*\*(.*)\*\*/', function($matches) {
			return '<strong>'.$matches[1].'</strong>';
		}, $input);

		// substitue les *italique*
		$input = preg_replace_callback('/\*(.*)\*/', function($matches) {
			return '<em>'.$matches[1].'</em>';
		}, $input);

		// subsitue les `code`
		$input = preg_replace_callback('/`(.*)`/', function($matches) {
			return '<code>'.$matches[1].'</code>';
		}, $input);

		// substitue les ![image](url)
		$input = preg_replace_callback('/!\[(.*)\]\((.*)\)/', function($matches) {
			return '<img src="'.$matches[2].'"">';
		}, $input);

		// substitue les [lien](url)
		$input = preg_replace_callback('/\[(.*)\]\((.*)\)/', function($matches) {
			return '<a href="'.$matches[2].'">'.$matches[1].'</a>';
		}, $input);

		// substitue les WikiLinks
		$input = preg_replace_callback('/[A-Z]\w+[A-Z]\w+/', function($matches) {
			return '<a href="'.\TP3\URL::rebase('/index.php/'.rawurlencode($matches[0])).'">'.$matches[0].'</a>';
		}, $input);
		
		// listes
		$input = preg_replace_callback('/^-\s*(.*)$/m', function($matches) {
			return '<ul><li>'.$matches[1].'</li></ul>';
		}, $input);

		// fusionne les listes adjacentes
		$input = preg_replace('/<\/ul>\r?\n<ul>/', '', $input);

		// paragraphes
		$input = '<p>'.preg_replace('/\r?\n\r?\n/', '</p><p>', $input).'</p>';

		return $input;
	}
}

