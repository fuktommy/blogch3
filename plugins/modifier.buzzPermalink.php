<?php
function smarty_modifier_buzzPermalink($url)
{
    $oldBase = 'http://www.google.com/buzz/104787602969620799839/';
    $base = 'https://profiles.google.com/fuktommy/posts/';

    if (preg_match('|^' . $oldBase . '(\w+)|', $url, $matches)) {
        return $base . $matches[1];
    }
    return $url;
}
