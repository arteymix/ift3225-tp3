<?php

namespace \TP3;

/**
 * Provider for {@link \Wiki} objects.
 */
abstract class \WikiProvider
{
	/**
	 * Find a {@link \TP3\Wiki} object given its wiki name.
	 *
	 * @return the corresponding
	 */
	public abstract function find_by_wiki_name ($wiki_name);
}
