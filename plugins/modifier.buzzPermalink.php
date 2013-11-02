<?php
function smarty_modifier_buzzPermalink($url, $mirrorlink = null)
{
    if (empty($mirrorlink)) {
        return $url;
    }
    $pattern = array(
        'http://www.google.com/buzz/104787602969620799839/',
        'https://profiles.google.com/fuktommy/buzz/',
        'https://profiles.google.com/fuktommy/posts/',
    );
    foreach ($pattern as $p) {
        if (strpos($url, $p) !== false) {
            return $mirrorlink;
        }
    }

    $url = str_replace(
        'https://plus.google.com/104787602969620799839/',
        'https://plus.google.com/+%E8%AB%AD%E7%A6%8F%E5%86%A8Fuktommy/',
        $url
    );
    return $url;
}
