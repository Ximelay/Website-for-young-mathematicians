<?php

if (!function_exists('parseUrls')) {
    function parseUrls($text)
    {
        return \App\Helpers\UrlHelper::parseUrls($text);
    }
}
