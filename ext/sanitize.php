<?php

namespace ext;

class Sanitize {

    public static function sanitizeString($input): string {
        $sanitized = trim($input);
        $sanitized = strip_tags($sanitized);
        return htmlentities($sanitized, ENT_QUOTES, 'UTF-8');
    }

    public static function sanitizeInt($input): array|string|null {
        return preg_replace("/[^0-9]/", "", $input);
    }

    public static function sanitizeEmail($input) {
        return filter_var($input, FILTER_SANITIZE_EMAIL);
    }

    public static function sanitizeRouteFolder($input) {
        return (isset($input[0]) && !preg_match('/[^A-Za-z0-9_]/', $input[0])) ? $input[0] : '';
    }

    public static function sanitizeRouteId($input) {
        return (isset($input[1]) && !preg_match('/[^0-9]/', $input[1])) ? $input[1] : '';
    }
}
