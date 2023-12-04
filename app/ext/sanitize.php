<?php

/**
 * Class that sanitizes certain number and text values
 */
class Sanitize {
	/**
	 * @param mixed $data
	 * 
	 * @return [type]
	 */
	public static function number($data) {
		return filter_var($data, FILTER_SANITIZE_NUMBER_INT);
	}
	
	/**
	 * @param mixed $data
	 * @param mixed $pdo
	 * 
	 * @return [type]
	 */
	public static function text($data, $pdo) {
		return $pdo->quote($data);
	}
}