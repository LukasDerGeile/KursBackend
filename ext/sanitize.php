<?php

class Sanitize
{
	public static function number($data)
	{
		return filter_var($data, FILTER_SANITIZE_NUMBER_INT);
	}
	
	public static function text($data, $pdo)
	{
		return $pdo->quote($data);
	}
}