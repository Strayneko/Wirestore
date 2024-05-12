<?php

use Illuminate\Support\Str;

/**
 * Clean title from whitespace on the end and begining of the string
 * Titleize the string
 * @param string|null $string
 * @return string|null
 */
function cleanAndTitleizeString(?string $string): ?string
{
    if(is_null($string)) return null;

    return Str::of($string)
            ->trim()
            ->title()
            ->toString();
}
