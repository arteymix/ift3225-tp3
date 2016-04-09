<?php

namespace TP3;

class URL
{
	/**
	 * Rebase thr provided URL in a context-sensitive manner. 
	 */
	public static function rebase ($url)
	{
		return getenv('BASEPATH').$url;
	}
}
