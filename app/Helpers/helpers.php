<?php

use Carbon\Carbon;
use Illuminate\Support\Str;

// ==============================
// FORMATTERS
// ==============================
if (!function_exists('formatDateTime')) {
    function formatDateTime($dateTime)
    {
        return $dateTime
            ? Carbon::parse($dateTime)->format('d-m-Y H:i:s')
            : null;
    }
}

// ==============================
// MENU HELPERS
// ==============================
if (!function_exists('isActiveMenu')) {
    function isActiveMenu($patterns, bool $useReturnUrl = false)
    {
        $locale = app()->getLocale();
        $request = request();
        $returnUrlPath = null;

        if ($useReturnUrl && $request->has('return_url')) {
            $parsed = parse_url($request->query('return_url'));
            if (!empty($parsed['path'])) {
                $returnUrlPath = ltrim($parsed['path'], '/');
            }
        }

        foreach ((array) $patterns as $pattern) {
            if ($request->is("$locale/$pattern") || $request->is($pattern)) {
                return true;
            }

            if ($useReturnUrl && $returnUrlPath) {
                if (Str::is($pattern, $returnUrlPath) || Str::is("$locale/$pattern", $returnUrlPath)) {
                    return true;
                }
            }
        }

        return false;
    }
}

if (!function_exists('menuOpenClass')) {
    function menuOpenClass($patterns, bool $useReturnUrl = false)
    {
        return isActiveMenu($patterns, $useReturnUrl) ? 'menu-open' : '';
    }
}

if (!function_exists('activeClass')) {
    function activeClass($patterns, bool $useReturnUrl = false)
    {
        return isActiveMenu($patterns, $useReturnUrl) ? 'active' : '';
    }
}

if (!function_exists('returnUrlMatches')) {
    function returnUrlMatches($patterns): bool
    {
        $request = request();
        if (!$request->has('return_url')) {
            return false;
        }

        $parsed = parse_url($request->query('return_url'));
        if (empty($parsed['path'])) {
            return false;
        }

        $locale = app()->getLocale();
        $path = ltrim($parsed['path'], '/');

        foreach ((array) $patterns as $pattern) {
            if (Str::is($pattern, $path) || Str::is("$locale/$pattern", $path)) {
                return true;
            }
        }

        return false;
    }
}
