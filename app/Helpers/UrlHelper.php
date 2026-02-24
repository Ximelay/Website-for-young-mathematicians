<?php

namespace App\Helpers;

class UrlHelper
{
    /**
     * Парсит текст и превращает URL в кликабельные ссылки
     */
    public static function parseUrls($text)
    {
        // Паттерн для поиска URL
        $pattern = '/(https?:\/\/[^\s<]+)/i';

        // Заменяем URL на <a> теги
        return preg_replace_callback($pattern, function($matches) {
            $url = $matches[1];
            $display = strlen($url) > 50 ? substr($url, 0, 47) . '...' : $url;

            return '<a href="' . htmlspecialchars($url) . '"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="text-indigo-600 hover:text-indigo-800 underline break-all">
                       ' . htmlspecialchars($display) . '
                    </a>';
        }, $text);
    }
}
