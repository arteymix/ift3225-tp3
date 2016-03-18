<?php

abstract class WikiProvider {

	/**
	 * Resolve an URI given a WikiWord.
	 */
	public abstract function resolve_uri($wiki_word);
}
