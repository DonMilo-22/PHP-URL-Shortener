<?php
final class UrlSafety
{
    public static function validate(string $url): ?string
    {
        if (strlen($url) > 2048) return "URL must be 2048 characters or fewer.";
        if (!filter_var($url, FILTER_VALIDATE_URL)) return "Enter a valid URL.";
        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
        if (!in_array($scheme, ["http", "https"], true)) return "Only http and https URLs are supported.";
        if (!parse_url($url, PHP_URL_HOST)) return "URL must include a host.";
        return null;
    }
}
