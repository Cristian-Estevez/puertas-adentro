<?php

/**
 * Formats a date string into Spanish using the Intl extension 
 * to produce the format: "mié. 15 de octubre de 2025".
 * * @param string $dateString The date string (e.g., '2025-10-15 08:20:09').
 * @return string The formatted date in Spanish.
 */
function formatToSpanish(string $dateString): string
{
    if (empty($dateString) || trim($dateString) === '0000-00-00 00:00:00') {
        return '—'; 
    }

    try {
        $date = new DateTime($dateString);
    } catch (\Exception $e) {
        return '—';
    }
    
    if (!class_exists('IntlDateFormatter')) {
        return date('D d M Y', $date->getTimestamp()); 
    }

    $formatter = new IntlDateFormatter(
        'es_ES',
        IntlDateFormatter::NONE,
        IntlDateFormatter::NONE,
        null,
        IntlDateFormatter::GREGORIAN,
        'E d \'de\' MMMM \'de\' yyyy' 
    );

    return $formatter->format($date);
}