<?php
function smarty_modifier_buzzPermalink($url)
{
    $rule = array(
        'src' => 'http://www.google.com/buzz/104787602969620799839/',
        'dst' => 'https://profiles.google.com/fuktommy/buzz/',
    );
    if (preg_match('|^' . $rule['src'] . '(\w+)|', $url, $matches)) {
        return $rule['dst'] . $matches[1];
    }

    $rule = array(
        'src' => 'https://profiles.google.com/fuktommy/posts/',
        'dst' => 'https://profiles.google.com/fuktommy/buzz/',
    );
    if (preg_match('|^' . $rule['src'] . '(\w+)|', $url, $matches)) {
        return $rule['dst'] . $matches[1];
    }

    return $url;
}
