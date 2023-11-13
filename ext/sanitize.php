<?php

namespace ext;

class sanitize {

    // Function to sanitize input strings
    public static function sanitizeString($input): string
    {
        // Remove leading and trailing whitespaces
        $sanitized = trim($input);
        // Remove HTML and PHP tags
        $sanitized = strip_tags($sanitized);
        // Convert special characters to HTML entities
        return htmlentities($sanitized, ENT_QUOTES, 'UTF-8');
    }

    // Function to sanitize integers
    public static function sanitizeInt($input): array|string|null
    {
        // Remove non-numeric characters
        return preg_replace("/[^0-9]/", "", $input);
    }

    // Function to sanitize email addresses
    public static function sanitizeEmail($input)
    {
        // Remove invalid characters from email
        return filter_var($input, FILTER_SANITIZE_EMAIL);
    }

    // Function to sanitize route folder
    public static function sanitizeRouteFolder($split_requesturi)
    {
        return (isset($split_requesturi[0]) && !preg_match('/[^A-Za-z0-9_]/', $split_requesturi[0])) ? $split_requesturi[0] : '';
    }

    // Function to sanitize route id
    public static function sanitizeRouteId($split_requesturi)
    {
        return (isset($split_requesturi[1]) && !preg_match('/[^0-9]/', $split_requesturi[1])) ? $split_requesturi[1] : '';
    }
}
