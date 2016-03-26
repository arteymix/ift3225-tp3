<?php

namespace TP3;

class Markdown
{
	public function __construct (\WikiProvider $wiki_provider) {
		$this->wiki_provider = $wiki_provider;
	}

	public function transform($input)
	{
		// en-têtes
		$input = preg_replace_callback('/^(#)+(.*)$/', function($matches) {
			return '<h'.strlen($matches[1]).'>'.htmlspecialchars($matches[2]).'</h'.strlen($matches[1]).'>';
		}, $input);

		// englobe les double '-' par des '<ul/>'
		// TODO: vérifier les captures multiples
		$input = preg_replace_callback('/-(.*)$-(.*)$+/', function($matches) {
			return '<ul>'.$matches[0].$matches[1].'</ul>';
		}, $input);

		// replace les - par des '<li/>'
		$input = preg_replace_callback('/<ul>(.*)<\/ul>/', function($matches) {

		}, $input);

		// substitue les **gras**
		$input = preg_replace_callback('/\*\*(.*)\*\*/', function($matches) {
			return '<strong>'.htmlspecialchars($matches[1]).'</strong>';
		}, $input);

		// substitue les *italique*
		$input = preg_replace_callback('/\*(.*)\*/', function($matches) {
			return '<em>'.htmlspecialchars($matches[1]).'</em>';
		}, $input);

		// substitue les [lien](url)
		$input = preg_replace_callback('/\[(.*)\]\(.*\)]', function($matches) {
			return '<a href="'.$matches[2].'">'.$matches[1].'</a>';
		}, $input);

		$input = preg_replace_callback('//', function($matches) {
			if ($uri = $this->page_provider->resolve_uri($matches[1]))
			{
				return '<a href="'.$uri.'">'.htmlspecialchars($matches[1]).'</a>';
			}
			else
			{
				return '<a class="missing">'.htmlspecialchars($matches[1]).'</a>';
			}
		});

		// paragraphes
		$input = preg_replace_callback('/(.*)\n\n/', function($matches) {
			return '<p>'.htmlspecialchars($matches[1]).'</p>';
		}, $input);

		// nouvelle lignes
		$input = nl2br($input);

		return $input;
	}
}

